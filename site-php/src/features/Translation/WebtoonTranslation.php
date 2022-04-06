<?php

namespace WebtoonLike\Site\features\Translation;

use WebtoonLike\Site\controller\ChapterController;
use WebtoonLike\Site\controller\WebtoonController;
use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\exceptions\NotFoundException;
use WebtoonLike\Site\exceptions\UnableToLoadImageException;
use WebtoonLike\Site\features\Import\Import;

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
    7. Exécution du script constructeur du rendu
 */


class WebtoonTranslation
{

    private array $registeredImages = [];

    /**
     * @param int $id
     * @param int $chapter
     * @param Language $lang
     *
     * @return array<Result>
     *
     * @throws NotFoundException|UnableToLoadImageException
     */
    public function getTranslatedWebtoonImages(int $id, int $chapter, Language $lang): array {
        if(!WebtoonController::exists($id)) throw new NotFoundException('Webtoon introuvable.', 001);
        $chapterId = ChapterController::exists($id, $chapter);
        if(!$chapterId) {
            try {
                $chapterId = Import::load($id, $chapter);
            } catch (NotFoundException) {
                throw new NotFoundException('Chapitre introuvable, tentatives de téléchargement échouées.', 002);
            }
        }
        $this->loadImages($chapterId);
    }

    /**
     * @param int $chapterId
     * @return void
     * @throws UnableToLoadImageException
     */
    private function loadImages(int $chapterId): void {
        $images = ChapterController::getAllImages($chapterId);
        $errors = [];
        foreach ($images as $image) {
            $res = $this->registerImage($image->getImageSrc(), $image->getOriginalLanguage());
            if (!$res) {
                $errors[] = $image;
            }
        }
        var_dump($errors);
        throw new UnableToLoadImageException();
    }

    private function registerImage(string $source, Language $lang): bool {

    }

    private function retrieveTextFromImage(int $index): string {

    }

    private function translate(): string {

    }

}