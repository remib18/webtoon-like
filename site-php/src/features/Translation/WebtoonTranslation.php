<?php

namespace WebtoonLike\Site\features\Translation;

use WebtoonLike\Site\controller\ChapterController;
use WebtoonLike\Site\controller\WebtoonController;
use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\exceptions\AlreadyExistingRessourceException;
use WebtoonLike\Site\exceptions\ApiException;
use WebtoonLike\Site\exceptions\NotFoundException;
use WebtoonLike\Site\exceptions\UnableToLoadImageException;
use WebtoonLike\Site\features\Import\Import;
use WebtoonLike\Site\features\Translation\APIs\TranslationInterface;
use WebtoonLike\Site\features\Translation\OCR\OCRInterface;
use WebtoonLike\Site\features\Translation\Result\Result;

/*
TODO: Steps to long-term most performance optimization :
    1. Convert original image to SVG
    2. Cleanup text from SVG image
    3. Reinsert text into SVG with text attribute
    4. For new translation, just need to change text with regex
*/

/*
TODO: Steps for now :
    0. Appel de `getTranslatedWebtoonImages` avec un webtoon et un chapitre
   ✅ 1. Vérification de l'existence du webtoon
   ✅ 2. Vérification de l'existence du chapitre
   ‼️     - Si non: tentatives d'import à l'aide du downloader
    3. Inscription de toutes les images
    4. Execution de l'GoogleOCR sur chaque image
    5. Traduction de chaque résultat
    6. Construction d'un objet `Result` qui contient:
        - Le chemin d'accès d'une image
        - La liste des bulles et de leurs positions contenant le text original et la traduction avec la position de chaque blocs
    7. Exécution du script constructeur du rendu (pas dans cette classe)
 */


class WebtoonTranslation
{

    private array $registeredImages = [];
    private OCRInterface $ocr;
    private TranslationInterface $translation;

    /** @var Result[] $results */
    private array $results = [];


    public function __construct(string $ocrClass, string $translationClass) {
        $this->ocr = new $ocrClass();
        $this->translation = new $translationClass();
    }

    /**
     * @param int $id
     * @param int $chapter
     * @param Language $lang
     *
     * @return Result[]
     *
     * @throws NotFoundException
     * @throws AlreadyExistingRessourceException
     * @throws ApiException
     */
    public function getTranslatedWebtoonImages(int $id, int $chapter, Language $lang): array {

        // Load images in a Result object, if necessary run OCR
        if(!WebtoonController::exists($id)) throw new NotFoundException('Webtoon introuvable.', 001);
        $chapterId = ChapterController::getByIndex($id, $chapter)->getId();
        if(!$chapterId) {
            try {
                $chapterId = Import::load($id, $chapter);
            } catch (NotFoundException) {
                throw new NotFoundException('Chapitre introuvable, tentatives de téléchargement échouées.', 002);
            }
        }

        // Perform translation
        $this->loadImages($chapterId);
        foreach ($this->results as $result) {
            foreach ($result->getBlocs() as $bloc) {
                $translation = $this->translation::translate($bloc->getOriginalText(), $result->getOriginalLanguage(), $lang);
                $bloc->setTranslatedText($translation);
            }
        }
        return $this->results;
    }

    /**
     * @param int $chapterId
     *
     * @return void
     * @throws ApiException
     */
    private function loadImages(int $chapterId): void {
        $images = ChapterController::getImages($chapterId);
        foreach ($images as $image) {
            $this->ocr->registerImage($image);
        }
        $this->results = $this->ocr->runOCR();
    }

}