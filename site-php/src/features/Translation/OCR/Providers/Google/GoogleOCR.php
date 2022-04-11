<?php

namespace WebtoonLike\Site\features\Translation\OCR\Providers\Google;

use Exception;
use Google\ApiCore\ValidationException;
use Google\Cloud\Vision\V1\AnnotateImageResponse;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use InvalidArgumentException;
use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\exceptions\ApiException;
use WebtoonLike\Site\exceptions\InvalidProtocolException;
use WebtoonLike\Site\features\Translation\OCR\OCRInterface;
use WebtoonLike\Site\features\Translation\Result\Bloc;
use WebtoonLike\Site\features\Translation\Result\Result;
use WebtoonLike\Site\utils\OCRUtils;
use WebtoonLike\Site\Settings;

class GoogleOCR implements OCRInterface
{

    private ImageAnnotatorClient $ocrClient;

    /** @var array<?Image> */
    private array $images = [];

    /** @var array<Result>  */
    private array $results= [];

    /** @var array<string> $texts */
    private array $texts;

    private int $workingIndex;

    private AnnotateImageResponse $response;

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
        } catch (Exception) {
            throw new ApiException('[OCR]: Unable to perform OCR using Google Cloud API.');
        }

        $this->ocrClient->close();
        return $this->results;
    }

    /**
     * @throws InvalidProtocolException
     * @throws \Google\ApiCore\ApiException
     */
    private function runSingle(int $index = 0): void {
        if (!isset($this->images[$index])) {
            throw new InvalidArgumentException('Index ' . $index . ' does not exist.');
        }
        $image = $this->images[$index];
        $this->workingIndex = $image->getIndex();
        $this->results[$this->workingIndex] = new Result($image->getPath());

        $this->response = $this->ocrClient->textDetection($image->getRessource());
        $this->setFontSize();
        $this->setTexts();
        $this->makeBlocs();
        $this->fixBlocs();

    }

    private function runBatch(): void {
        // TODO: Implement batch call
        // See : https://stackoverflow.com/questions/71827453/google-cloud-vision-php-make-batch-request
        // See : https://cloud.google.com/vision/docs/batch#sample_code
    }

    private function setTexts(): void {
        $textAnnotations = $this->response->getTextAnnotations();
        for ($i = 1; $i < sizeof($textAnnotations); $i++) {
            $this->texts[] = $textAnnotations[$i]->getDescription();
        }
    }

    private function makeBlocs(): void {
        foreach ($this->response->getFullTextAnnotation()->getPages() as $page) {
            foreach ($page->getBlocks() as $block) {
                $text = '';
                $start = null;
                $end = null;
                foreach ($block->getParagraphs() as $paragraph) {
                    foreach ($paragraph->getWords() as $word) {
                        if ($start === null) {
                            $start = OCRUtils::vertexToPosition($word->getBoundingBox()->getVertices()[0]);
                        }
                        $end = OCRUtils::vertexToPosition($word->getBoundingBox()->getVertices()[2]);
                        $text .= ' ' . array_shift($this->texts);
                    }
                }
                $this->results[$this->workingIndex]->appendBloc(new Bloc($text, $start, $end));
            }
        }
    }

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

    private function fixBlocs(): void {
        $initialBlocs = $this->results[$this->workingIndex]->getBlocs();
        $blocs = [];
        for ($i = 0; $i < sizeof($initialBlocs); $i++) {
            $append = false;
            $current = $initialBlocs[$i];
            foreach ($initialBlocs as $next) {
                if (OCRUtils::proximityChecks($current, $next, $this->results[$this->workingIndex]->getFontSize())) {
                    $blocs[] = Bloc::merge($current, $next);
                    $append = true;
                    $i++;
                    break;
                }
            }
            if (!$append) {
                $blocs[] = $current;
            }
        }
        $this->results[$this->workingIndex]->setBlocs($blocs);
    }
}