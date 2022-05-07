<?php

namespace WebtoonLike\Site\pageManager;

use WebtoonLike\Site\controller\ChapterController;
use WebtoonLike\Site\controller\WebtoonController;
use WebtoonLike\Site\core\Router;
use WebtoonLike\Site\entities\Webtoon;

class WebtoonManager
{
    public static function CheckNull():void{
        if(is_null(self::getWebtoon())){
            Router::redirect('/error', 301, ['msg' => 'Nous n\'avons pas réussie à trouver le Webtoon']);
        }
    }
    private static function getWebtoon(): ?Webtoon {
        return WebtoonController::getById((int)$_GET['id']);
    }

    public static function getName(): string {
        return self::getWebtoon()->getName();
    }
    public static function getId(): ?int {
        return self::getWebtoon()->getId();
    }

    public static function getChapters(): string {
        $requestedIndex = (int)( $_GET['chapter'] ?? 1 );
        $res = '';

        foreach (ChapterController::getAllForWebtoon(self::getWebtoon()->getId()) as $chapter) {
            $chapterIndex = $chapter->getIndex();
            $chapterTitle = $chapter->getTitle();

            if ($requestedIndex === $chapterIndex) {
                $res .= "<option value='$chapterIndex' selected>Chapitre $chapterTitle</option>";
            } else {
                $res .= "<option value='$chapterIndex'>Chapitre $chapterTitle</option>";
            }
        }
        return $res;
    }

    public static function getDescription(): string {
        return self::getWebtoon()->getDescription();
    }

}