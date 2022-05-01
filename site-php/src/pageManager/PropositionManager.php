<?php

namespace WebtoonLike\Site\pageManager;

use WebtoonLike\Site\controller\BlockController;
use WebtoonLike\Site\controller\TranslationController;
use WebtoonLike\Site\controller\TranslationPropositionController;
use WebtoonLike\Site\core\Router;
use WebtoonLike\Site\entities\Block;
use WebtoonLike\Site\entities\Translation;
use WebtoonLike\Site\entities\TranslationProposition;

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
                header('Location: /error?');
            }
        }
        if (is_null(self::$block)) {
            header('Location: /error?');
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
            header('Location: http://localhost/error?');
        }
        return self::$translation;
    }

    public static function getContent(): string
    {
        return self::getTranslation()->getContent()/*Translation*/ ;
    }

    public static function setProposition(int $userId, int $blockId, string $Proposition): ?TranslationProposition
    {
        return new TranslationProposition(null,$Proposition,$blockId,$userId,false);
    }

    public static function SaveProposition(): void
    {
        $Proposition="";
        if(isset($_GET['TranslationId']) && isset($_GET['BlockId'])) {
            $userId=$_SESSION['id'];
            $blockId=$_GET['BlockId'];
            $Proposition .=$_POST['proposition'];
            $PropositionTranslation = self::setProposition($userId, $blockId, $Proposition);
            if(TranslationPropositionController::create($PropositionTranslation)) {
                header('Location: /');
            }else{
                Router::redirect('/proposition', 301, ['error' => 'Nous n\'avons pas réussie à enregistrer la proposition']);
            }
        }else{
            Router::redirect('/proposition', 301, ['error' => 'Nous n\'avons pas retrouver le texte']);
        }
    }

}