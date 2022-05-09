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
    /*
     * Vérifie l'origine du texte à modifier
     */
    public static function CheckNull(): void {
        if (is_null(self::getBlock()) || is_null(self::getTranslation())){
            Router::redirect('/error', 301, ['msg' => 'Nous n\'avons pas réussi à trouver le texte']);
        }
    }

    /*
     * Vérifie si l'utilisateur à un compte
     */
    public static function ChecKUser(): void {
        if (!(isset($_SESSION['id']))){
            Router::redirect('/login', 301, ['error' => 'Vous devez vous connecter pour faire des proposition']);
        }
    }

    ############# TEXTE ORIGINAL ##############
    /*
     * Obtenir le block grace à son id
     */
    private static function getBlock(): ?Block
    {
        return BlockController::getById((int)$_GET['BlockId']);
    }

    /*
     * Obtenir le texte original (du block)
     */
    public static function getOriginalContent(): string
    {
        return self::getBlock()->getOriginalContent();
    }

    ############### TRADUCTION DU TEXTE #####################

    public static function getBId(): int
    {
        return self::getBlock()->getId();
    }

    /*
     * Obtenir le texte original
     */
    private static function getTranslation(): ?Translation
    {
        $trId = $_GET['TranslationId'];
        $BlkId = self::getBId();
        return TranslationController::get($trId, $BlkId);
    }

    /*
     * Obtenir la traduction du texte original
     */
    public static function getContent(): string
    {
        return self::getTranslation()->getContent();
    }

    /*
     * Créer l'objet pour sauvgarder la proposition
     */
    public static function setProposition(int $userId, int $blockId, string $Proposition): ?TranslationProposition
    {
        return new TranslationProposition(null, $Proposition, $blockId, $userId, false);
    }

    /*
     * Sauvegarde la proposition
     */
    public static function SaveProposition(): void
    {
        $Proposition = "";
        $userId = $_SESSION['id'];
        $blockId = $_GET['BlockId'];
        $Proposition .= $_POST['proposition'];
        $PropositionTranslation = self::setProposition($userId, $blockId, htmlentities($Proposition));

        if (TranslationPropositionController::create($PropositionTranslation)) {
            Router::redirect('/home', null , ['msg' => 'Proposition soumise']);
        } else {
            Router::redirect('/error', 301, ['msg' => 'Nous n\'avons pas réussie à enregistrer la proposition']);
        }
    }

}