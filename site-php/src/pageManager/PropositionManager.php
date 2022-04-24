<?php

namespace WebtoonLike\Site\pageManager;

use WebtoonLike\Site\controller\BlockController;
use WebtoonLike\Site\controller\TranslationController;
use WebtoonLike\Site\entities\Block;
use WebtoonLike\Site\entities\Translation;

class PropositionManager
{
    static ?Block $block = null;
    static ?Translation $translation = null;

    ############# TEXTE ORIGINAL ##############
    private static function getBlock(): Block
    {
        if (is_null(self::$block)) {
            if (isset($_GET['BlockId']/*BlockId*/)) {
                self::$block = BlockController::getById((int)$_GET['BlockId']);
            } else {
                var_dump($_GET);
                header('Location: http://localhost/error?');
            }
        }
        if (is_null(self::$block)) {
            var_dump(self::$block);
            header('Location: http://localhost/error?');
        }
        return self::$block;
    }

    public static function getOriginalContent(): string
    {
        return self::getBlock()->getOriginalContent()/*Block*/ ;
    }

    ############### TRADUCTION DU TEXTE #####################

    public static function getBId(): int
    {
        return self::getBlock()->getId()/*Block*/ ;
    }

    private static function getTranslation(): Translation
    {
        if (is_null(self::$translation)) {
            if (isset($_GET['TranslationId']/*TranslationId*/)) {
                $trId = $_GET['TranslationId'];
                $BlkId = self::getBId();
                self::$translation = TranslationController::get($trId, $BlkId);

            } else {
                var_dump($_GET);
                header('Location: http://localhost/error?');
            }
        }
        if (is_null(self::$translation)) {
            var_dump(self::$translation);
            header('Location: http://localhost/error?');
        }
        return self::$translation;
    }

    public static function getContent(): string
    {
        return self::getTranslation()->getContent()/*Translation*/ ;
    }


}