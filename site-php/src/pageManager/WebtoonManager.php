<?php

namespace WebtoonLike\Site\pageManager;

use WebtoonLike\Site\controller\ChapterController;
use WebtoonLike\Site\controller\WebtoonController;
use WebtoonLike\Site\entities\Webtoon;

class WebtoonManager
{
    static ?Webtoon $webtoon = null;

    private static function getWebtoon(): Webtoon {
        if (is_null(self::$webtoon)) {
            if (isset($_GET['id'])) {
                self::$webtoon = WebtoonController::getById((int)$_GET['id']);
            } else {
                header('Location: http://localhost/error?');
            }
        }
        return self::$webtoon;
    }

    public static function getName(): string {
        return self::getWebtoon()->getName();
    }

    public static function getChapters(): string {
        $requestedIndex = (int)( $_GET['chapter'] ?? 1 );
        $res = '';

        foreach (ChapterController::getAllForWebtoon(self::$webtoon->getId()) as $chapter) {
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