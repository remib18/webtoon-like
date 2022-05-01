<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\NoIdOverwritingException;
use WebtoonLike\Site\entities\TranslationProposition;
use WebtoonLike\Site\utils\Database;

class TranslationPropositionController
{

    /**
     * Obtenir la traduction proposé correspondante.
     *
     * @param string $proposition
     * @param int    $blockID
     * @param int    $userID
     *
     * @return TranslationProposition|null
     */
    public static function get(string $proposition, int $blockID, int $userID): ?TranslationProposition {
        return Database::getFirst('TranslationProposition', TranslationProposition::class, '*', [
            'languageIdentifier' => "languageIdentifier = '$proposition'",
            'blockID' => "AND blockID = $blockID",
            'userID' => "AND userID = $userID"
        ]);
    }

    /**
     * Enregistrer les modifications de la traduction proposé
     *
     * @param TranslationProposition $entity
     *
     * @return bool
     */
    public static function edit(TranslationProposition &$entity): bool {
        return Database::edit('TranslationProposition', $entity);
    }

    /**
     * Enregistrer la création de la traduction proposé
     *
     * @param TranslationProposition $entity
     *
     * @return bool
     * @throws NoIdOverwritingException
     */
    public static function create(TranslationProposition &$entity): bool {
        return Database::create('TranslationProposition', $entity);
    }

    /**
     * Suppression de la traduction proposé
     *
     * @param TranslationProposition $entity
     *
     * @return bool
     */
    public static function remove(TranslationProposition $entity): bool {
        return Database::remove('TranslationProposition', $entity);
    }

}