<?php

namespace WebtoonLike\Site\pageManager;

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
                //header('Location: /');
            }
        }
        if (is_null(self::$webtoon)) {
            var_dump(self::$webtoon);
            //header('Location: /');
        }
        return self::$webtoon;
    }

    public static function getName(): string {
        return self::getWebtoon()->getName();
    }

}