<?php

namespace WebtoonLike\Site\pageManager;

use WebtoonLike\Site\controller\ChapterController;
use WebtoonLike\Site\controller\WebtoonController;
use WebtoonLike\Site\core\Router;
use WebtoonLike\Site\entities\Webtoon;

class WebtoonManager
{
    /*
     * Vérifie que le webtoon éxiste
     */
    public static function CheckNull(): void {
        if (is_null(self::getWebtoon())){
            Router::redirect('/error', 301, ['msg' => 'Nous n\'avons pas réussie à trouver le Webtoon']);
        }
    }

    /*
     * Récupère le webtoon grace à l'id
     */
    private static function getWebtoon(): ?Webtoon {
        return (is_numeric($_GET['id'])) ? WebtoonController::getById((int)$_GET['id']) : null;
    }

    /*
     * Obtenir le nom du webtoon
     */
    public static function getName(): string {
        return self::getWebtoon()->getName();
    }

    /*
     * Obtenir l'id du webtoon
     */
    public static function getId(): ?int {
        return self::getWebtoon()->getId();
    }

    /*
     * Récupère les chapitre lié au webtoon
     */
    public static function getChapters(): string {
        $requestedIndex = (int)($_GET['chapter']) ?? 1;
        $res = '';

        foreach (ChapterController::getAllForWebtoon(self::getWebtoon()->getId()) as $chapter) {
            $chapterIndex = $chapter->getIndex();
            $chapterTitle = $chapter->getTitle();

            if ($requestedIndex === $chapterIndex) {
                $res .= "<a href='#'><option value='$chapterIndex' selected>Chapitre $chapterTitle</option></a>";
            } else {
                $res .= "<a href='#'><option value='$chapterIndex'>Chapitre $chapterTitle</option></a>";
            }
        }
        return $res;
    }

    /*
     * Obtient la description du webtoon
     */
    public static function getDescription(): string {
        return self::getWebtoon()->getDescription();
    }

    public static function getNbChap():array {
        return self::getWebtoon()->getNbChap();
    }

    public static function getDescription():stringSSSSSSSS {
        return self::getWebtoon()->getDescription();
    }

}