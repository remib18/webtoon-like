<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\NoIdOverwritingException;
use WebtoonLike\Site\entities\Translation;
use WebtoonLike\Site\utils\Database;

class TranslationController
{

    /**
     * Obtenir la traduction correspondante.
     *
     * @param string $languageId
     * @param int $blockID
     *
     * @return Translation|null
     */
    public static function get(string $languageId, int $blockID): ?Translation
    {
        return Database::getFirst('Translation', Translation::class, '*', [
            'languageIdentifier' => "languageIdentifier = '$languageId'",
            'blockID' => "AND blockID = $blockID"
        ]);
    }

    /**
     * Enregistrer les modifications de la traduction
     *
     * @param Translation $entity
     *
     * @return bool
     */
    public static function edit(Translation &$entity): bool
    {
        return Database::edit('Translation', $entity);
    }

    /**
     * Enregistrer la création de la traduction
     *
     * @param Translation $entity
     *
     * @return bool
     * @throws NoIdOverwritingException
     */
    public static function create(Translation &$entity): bool
    {
        return Database::create('Translation', $entity);
    }

    /**
     * Suppression de la traduction
     *
     * @param Translation $entity
     *
     * @return bool
     */
    public static function remove(Translation $entity): bool
    {
        return Database::remove('Translation', $entity);
    }

}