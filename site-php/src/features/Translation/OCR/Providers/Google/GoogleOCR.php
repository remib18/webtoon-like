<?php

namespace WebtoonLike\Site\features\Translation\OCR\Providers\Google;

use Google\ApiCore\ValidationException;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Image as GCImage;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use WebtoonLike\Site\entities\Block;
use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\exceptions\ApiException;
use WebtoonLike\Site\features\Translation\OCR\OCRInterface;
use WebtoonLike\Site\features\Translation\Result\Result;
use WebtoonLike\Site\Settings;
use WebtoonLike\Site\utils\Database;

class GoogleOCR implements OCRInterface
{

    private ImageAnnotatorClient $ocrClient;

    /** @var array<?Image> */
    private array $images = [];

    /** @var Result[]  */
    private array $results= [];

    /** @var Image[] $toGetFromDB Buffer pour les images à aller chercher dans la db */
    private array $toGetFromDB = [];

    private int $chapterId;

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

    public function registerChapterId(int $chapterId): void {
        $this->chapterId = $chapterId;
    }

    /**
     * @inheritDoc
     */
    public function runOCR(): array
    {
        try {
            $this->runBatch();
        } catch (\Google\ApiCore\ApiException $e) {
            // TODO gérer les erreurs (nota too many images for request)
            var_dump($e->getMessage());
            var_dump($this->images);
            throw new ApiException('[OCR]: Unable to perform OCR using Google Cloud API.');
        }

        $this->getResults();
        return $this->results;
    }

    /**
     * Effectue le traitement pour toutes les images.
     *
     * @return void
     *
     * @throws \Google\ApiCore\ApiException
     */
    private function runBatch(): void {
        try {
            $textDetection = (new Feature())
                ->setType(Feature\Type::TEXT_DETECTION);
            $documentDetection = (new Feature())
                ->setType(Feature\Type::DOCUMENT_TEXT_DETECTION);

            $requests = [];
            $imagesToHandle = [];
            foreach ($this->images as $image) {
                if ($image->doesNeedOCR()) {
                    $path = Settings::get('WEBTOONS_IMAGES_FOLDER') . '/' . $image->getPath();
                    $gcImage = (new GCImage())
                        ->setContent(file_get_contents($path,"r"));

                    $requests[] = (new AnnotateImageRequest())
                        ->setImage($gcImage)
                        ->setFeatures([$textDetection, $documentDetection]);
                    $imagesToHandle[] = $image;
                } else {
                    $this->toGetFromDB[] = $image;
                }
            }

            $results = $this->ocrClient->batchAnnotateImages($requests);
            $i = 0;
            foreach($results->getResponses() as $result){
                $image = $imagesToHandle[$i];
                // Traite l'image, Obtention par la suite via BDD
                (new ResponseHandling($result, $image))->handle();
                $i++;
            }

        } finally {
            $this->ocrClient->close();
        }
    }

    private function getResults(): void {
        $chapterId = $this->chapterId;
        $q = "SELECT Block.blockID, Block.originalContent, Block.startX, Block.startY, Block.endX, Block.endY, Block.imageID FROM Chapter INNER JOIN Image USING (chapterID) INNER JOIN Block USING (imageID) WHERE chapterID = $chapterId;";
        $blocks = Database::responseToObjects(
            Database::getDB()->query($q)->fetch_all(MYSQLI_ASSOC),
            Block::class
        );
        foreach ($this->images as $image) {
            $res = new Result($image->getPath(), $image->getOriginalLanguage());
            $res->setFontSize($image->getFontSize());
            $res->setBlocks($this->getBlockForImage($blocks, $image), true);
            $this->results[$image->getIndex()] = $res;
        }
    }

    private function getBlockForImage(array $blocks, Image $image): array {
        $res = [];
        foreach ($blocks as $block) {
            if ($block->getImageId() === $image->getId()) {
                $res[$block->getId()] = $block;
            }
        }
        return $res;
    }
}