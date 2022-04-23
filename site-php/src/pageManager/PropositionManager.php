<?php

namespace WebtoonLike\Site\pageManager;

use WebtoonLike\Site\entities\Block;
use WebtoonLike\Site\entities\Translation;

class PropositionManager
{
    static ?Block $block = null;

    public static function getContent(): string
    {
        return self::getBlock()->getContent();
    }

    private static function getBlock(): Block
    {
        if (is_null(self::$block)) {
            if (isset($_GET['id']/*BlockId*/)) {
                ##self::$block = WebtoonController::getById((int)$_GET['id']);
            } else {
                var_dump($_GET);
                header('Location: /');
            }
        }
        if (is_null(self::$block)) {
            var_dump(self::$block);
            header('Location: /');
        }
        return self::$block;
    }

    public static function getOriginalContent(): string
    {
        return self::getBlock()->getOriginalContent();
    }

    private static function getTranslation(): Translation
    {
        if (is_null(self::$block)) {
            if (isset($_GET['id']/*BlockId*/)) {
                self::$block = WebtoonController::getById((int)$_GET['id']);
            } else {
                var_dump($_GET);
                header('Location: /');
            }
        }
        if (is_null(self::$block)) {
            var_dump(self::$block);
            header('Location: /');
        }
        return self::$block;
    }

    /*if (isset($_GET['imageID'])){
        $imageId = setImageId((int) $_GET['imageID']);
    }*/
}