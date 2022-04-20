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
                var_dump($_GET);
                header('Location: /');
            }
        }
        if (is_null(self::$webtoon)) {
            var_dump(self::$webtoon);
            header('Location: /');
        }
        return self::$webtoon;
    }

    public static function getName(): string {
        return self::getWebtoon()->getName();
    }

    public static function getChapters(): string {
        if (!(isset($_GET['chapter']))) {
            header('Location: /');
        }
        $chapters =ChapterController::getAll();
        $res="";

        foreach ($chapters as $chapter) {
            if( (int) $_GET['chapter'] === $chapter->getIndex()) {
                $res .= '<option value="' . $chapter->getIndex() . '" selected>Chapitre ' . $chapter->getTitle() . '</option>';
            }else{
                $res .= '<option value="' . $chapter->getIndex() . '">Chapitre ' . $chapter->getTitle() . '</option>';
            }
    }
        return $res;
    }

    public static function getDescription(): string {
        return self::getWebtoon()->getDescription();
    }

}