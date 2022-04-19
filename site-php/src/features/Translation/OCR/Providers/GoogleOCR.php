<?php

namespace WebtoonLike\Site\features\Translation\OCR\Providers;

use Google\ApiCore\ValidationException;
use Google\Cloud\Vision\V1\AnnotateImageResponse;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Vertex;
use InvalidArgumentException;
use WebtoonLike\Site\controller\BlockController;
use WebtoonLike\Site\controller\ImageController;
use WebtoonLike\Site\entities\Block;
use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\exceptions\ApiException;
use WebtoonLike\Site\exceptions\InvalidProtocolException;
use WebtoonLike\Site\features\Translation\OCR\OCRInterface;
use WebtoonLike\Site\features\Translation\Result\Result;
use WebtoonLike\Site\Settings;
use WebtoonLike\Site\utils\OCRUtils;

class GoogleOCR implements OCRInterface
{

    private ImageAnnotatorClient $ocrClient;

    /** @var array<?Image> */
    private array $images = [];

    /** @var array<Result>  */
    private array $results= [];

    /** @var array<string> $texts */
    private array $texts = [];

    private ?int $workingIndex;

    private ?AnnotateImageResponse $response;

    /**
     * @throws ValidationException
     */
    public function __construct()
    {
        $this->ocrClient = new ImageAnnotatorClient([
            'credentials' => json_decode(file_get_contents(
                Settings::get('GT_API_KEY_FILE')
            ), true)
        ]);
    }

    /**
     * @inheritDoc
     */
    public function registerImage(Image $image): OCRInterface
    {
        $this->images[] = $image;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function runOCR(): array
    {
        try {
            if (sizeof($this->images) > 1) {
                $this->runBatch();
            } else {
                $this->runSingle();
            }
        } catch (\Google\ApiCore\ApiException $e) {
            throw new ApiException('[OCR]: Unable to perform OCR using Google Cloud API.');
        }

        $this->ocrClient->close();
        return $this->results;
    }

    /**
     * Effectue un appel API pour une image
     *
     * @param int $index Index de l'image dans la pile de traitement
     *
     * @return void
     *
     * @throws InvalidProtocolException
     * @throws \Google\ApiCore\ApiException
     */
    private function runSingle(int $index = 0): void {
        if (!isset($this->images[$index])) {
            var_dump($this->images);
            throw new InvalidArgumentException('Index ' . $index . ' does not exist.');
        }

        $image = $this->images[$index];

        if ($image->doesNeedOCR()) {
            $this->workingIndex = $image->getIndex();
            $this->results[$this->workingIndex] = new Result($image->getPath(), $image->getOriginalLanguage());

            $this->response = $this->ocrClient->textDetection($image->getRessource());
            $this->setFontSize();
            $this->setTexts();
            $this->makeBlocs($image);
            $this->fixBlocs();

            $image->setNeedOCR(false);

            $this->saveInDB($image);
        } else {
            $this->getResultFromDB($image);
            //throw new OCRAlreadyPerformedException();
        }
    }

    /**
     * Effectue le traitement pour toutes les images.
     *
     * @note: Actuellement utilise un appel api par image,
     * car manque de documentation pour l'implémentation de la requête batch...
     *
     * @return void
     *
     * @throws InvalidProtocolException
     * @throws \Google\ApiCore\ApiException
     *
     * @todo: Optimize batch call
     * @see StackOverflowIssue : https://stackoverflow.com/questions/71827453/google-cloud-vision-php-make-batch-request
     * @see OfficialDocumentation : https://cloud.google.com/vision/docs/batch#sample_code
     *
     */
    private function runBatch(): void {


        // Temporary implementation
        for ($i = 0; $i < sizeof($this->images); $i++) {
            $this->runSingle($i);
            $this->resetForNext();
        }
    }

    /**
     * Obtention des textes
     *
     * @return void
     */
    private function setTexts(): void {
        $textAnnotations = $this->response->getTextAnnotations();
        for ($i = 1; $i < sizeof($textAnnotations); $i++) {
            $this->texts[] = $textAnnotations[$i]->getDescription();
        }
    }

    /**
     * Créations des blocs
     *
     * @return void
     */
    private function makeBlocs(Image $image): void {
        foreach ($this->response->getFullTextAnnotation()->getPages() as $page) {
            foreach ($page->getBlocks() as $block) {
                $text = '';
                $start = null;
                $end = null;
                foreach ($block->getParagraphs() as $paragraph) {
                    foreach ($paragraph->getWords() as $word) {
                        if ($start === null) {
                            $start = new Vertex(); //$word->getBoundingBox()->getVertices()[0];
                        }
                        $end = $word->getBoundingBox()->getVertices()[2];
                        $text .= ' ' . array_shift($this->texts);
                    }
                }
                $this->results[$this->workingIndex]->appendBlock(
                    new Block(null, $text, $start->getX(), $start->getY(), $end->getX(), $end->getY(), $image->getId(), false)
                );
            }
        }
    }

    /**
     * Création de la taille de police
     *
     * @return void
     */
    function setFontSize(): void {
        $charVertices = $this->response
            ->getFullTextAnnotation()
            ->getPages()[0]
            ->getBlocks()[0]
            ->getParagraphs()[0]
            ->getWords()[0]
            ->getSymbols()[0]
            ->getBoundingBox()
            ->getVertices();
        $start = OCRUtils::vertexToPosition($charVertices[0])->getY();
        $end = OCRUtils::vertexToPosition($charVertices[2])->getY();
        $this->results[$this->workingIndex]->setFontSize($end - $start);
    }

    /**
     * Mise à jour des blocs pour correspondre à un vrai bloc
     *
     * @return void
     */
    private function fixBlocs(): void {
        $initialBlocks = $this->results[$this->workingIndex]->getBlocks();
        $blocs = [];
        for ($i = 0; $i < sizeof($initialBlocks); $i++) {
            $append = false;
            $current = $initialBlocks[$i];
            foreach ($initialBlocks as $next) {
                if (OCRUtils::proximityChecks($current, $next, $this->results[$this->workingIndex]->getFontSize())) {
                    $blocs[] = Block::merge($current, $next);
                    $append = true;
                    $i++;
                    break;
                }
            }
            if (!$append) {
                $blocs[] = $current;
            }
        }
        $this->results[$this->workingIndex]->setBlocks($blocs);
    }

    /**
     * Préparation au prochain appel
     *
     * @return void
     */
    private function resetForNext(): void {
        $this->texts = [];
        $this->workingIndex = null;
        $this->response = null;
    }

    private function getResultFromDB(Image $image) {
        $res = new Result($image->getPath(), $image->getOriginalLanguage());
        $res->setFontSize($image->getFontSize());
        foreach (ImageController::getBlocks($image->getId()) as $block) {
            $res->appendBlock($block);
        }
        $this->results[$image->getIndex()] = $res;
    }

    private function saveInDB(Image $image): void {
        $blocks = $this->results[$image->getIndex()]->getBlocks();
        BlockController::createBatch($blocks);
        $this->results[$image->getIndex()]->setBlocks($blocks);
    }
}