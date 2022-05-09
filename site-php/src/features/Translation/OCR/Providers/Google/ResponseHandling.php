<?php

namespace WebtoonLike\Site\features\Translation\OCR\Providers\Google;

use Error;
use Exception;
use Google\Cloud\Vision\V1\AnnotateImageResponse;
use WebtoonLike\Site\controller\BlockController;
use WebtoonLike\Site\controller\ImageController;
use WebtoonLike\Site\entities\Block;
use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\entities\NoIdOverwritingException;
use WebtoonLike\Site\features\Translation\Result\Result;
use WebtoonLike\Site\Settings;
use WebtoonLike\Site\utils\OCRUtils;

class ResponseHandling
{

    private Result $result;

    /** @var array<string> $texts */
    private array $texts = [];

    /**
     * @param AnnotateImageResponse $response
     * @param Image                 $image
     */
    public function __construct(private readonly AnnotateImageResponse $response, private readonly Image $image) {
        $this->result = new Result($this->image->getPath(), $this->image->getOriginalLanguage());
        $this->getImageDimensions();
    }

    /**
     * Calcule et renvoie les dimensions de l'image
     *
     * @return array
     */
    public function getImageDimensions(): array {
        $path = Settings::get('WEBTOONS_IMAGES_FOLDER') . $this->image->getPath();
        $res = getimagesize($path);
        return [
            'width'  => $res[0],
            'height' => $res[1]
        ];
    }

    /**
     * Traite la réponse
     *
     * @return void
     * @throws NoIdOverwritingException
     */
    public function handle(): void {
        $this->setFontSize();
        $this->setTexts();
        $this->makeBlocs();
        $this->fixBlocs();

        $this->saveInDB();
    }

    /**
     * Obtention de la taille de police (approximation)
     *
     * @return void
     */
    private function setFontSize(): void {
        /*$charVertices = $this->response
            ->getFullTextAnnotation()
            ->getPages()[0]
            ->getBlocks()[0]
            ->getParagraphs()[0]
            ->getWords()[0]
            ->getSymbols()[0]
            ->getBoundingBox()
            ->getVertices();
        $start = $charVertices[0]->getY();
        $end = $charVertices[2]->getY();
        $this->result->setFontSize($end - $start);*/
        $this->result->setFontSize(16);
    }

    /**
     * Obtention des textes
     *
     * @return void
     */
    private function setTexts() {
        $textAnnotations = $this->response->getTextAnnotations();
        for ($i = 1; $i < sizeof($textAnnotations); $i++) {
            $this->texts[] = $textAnnotations[$i]->getDescription();
        }
    }

    /**
     * Création des blocks
     *
     * @return void
     */
    private function makeBlocs() {
        try {
            foreach ($this->response->getFullTextAnnotation()->getPages() as $page) {
                foreach ($page->getBlocks() as $block) {
                    $text = '';
                    $start = null;
                    $end = null;
                    foreach ($block->getParagraphs() as $paragraph) {
                        foreach ($paragraph->getWords() as $word) {
                            if ($start === null) {
                                $start = $word->getBoundingBox()->getVertices()[0];
                            }
                            $end = $word->getBoundingBox()->getVertices()[2];
                            $text .= ' ' . array_shift($this->texts);
                        }
                    }
                    $this->result->appendBlock(new Block(
                                                   null,
                                                   $text,
                                                   $start->getX(),
                                                   $start->getY(),
                                                   $this->getImageDimensions()['width'] - $end->getX(),
                                                   $this->getImageDimensions()['height'] - $end->getY(),
                                                   $this->image->getId(),
                                                   false
                                               ));
                }
            }
        } catch (Exception|Error) {

        }
    }

    /**
     * Ajustement des blocks
     *
     * @return void
     */
    private function fixBlocs() {
        $initialBlocks = $this->result->getBlocks();
        $blocks = [];
        for ($i = 0; $i < sizeof($initialBlocks); $i++) {
            $append = false;
            $current = $initialBlocks[$i];
            foreach ($initialBlocks as $next) {
                if (OCRUtils::proximityChecks($current, $next, $this->result->getFontSize())) {
                    $blocks[] = Block::merge($current, $next);
                    $append = true;
                    $i++;
                    break;
                }
            }
            if (!$append) {
                $blocks[] = $current;
            }
        }
        $this->result->setBlocks($blocks, false);
    }

    /**
     * Sauvegarde des blocs dans la BDD et modification de l'image
     *
     * @return void
     * @throws NoIdOverwritingException
     */
    private function saveInDB(): void {
        // Enregistrement des blocs
        $blocks = $this->result->getBlocks();
        if (sizeof($blocks) > 0) BlockController::createBatch($blocks);
        $this->result->setBlocks($blocks, true);

        // Modification de l'image
        $this->image->setNeedOCR(false);
        $this->image->setFontSize($this->result->getFontSize());
        ImageController::edit($this->image);
    }

}