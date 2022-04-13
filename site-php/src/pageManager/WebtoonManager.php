<?php

namespace WebtoonLike\Site\pageManager;

use WebtoonLike\Site\controller\WebtoonController;
use WebtoonLike\Site\entities\Webtoon;

class WebtoonManager
{
    static Webtoon $webtoon;

    private static function getWebtoon(): Webtoon {
        if (!isset(self::$webtoon)) {
            if (!(isset($_POST['id']) && is_numeric($_POST['id']))) {
                self::$webtoon = WebtoonController::getById((int)$_POST['id']);
            } else {
                header('Location: /');
            }
        }
        return self::$webtoon;
    }

    public static function getName(): string {
        return 'The Beginning after the end';
    }

}