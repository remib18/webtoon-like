<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\entities\NoIdOverwritingException;
use WebtoonLike\Site\utils\Database;

class LanguageController
{

    /**
     * Obtenir la liste des langages
     *
     * @return Language[]
     */
    public static function getAll(): array {
        return Database::getAll('Language', Language::class, '*', []);
    }

    /**
     * Obtenir le langage correspondant.
     *
     * @param string $languageId
     *
     * @return Language|null
     */
    public static function getById(string $languageId): ?Language {
        return Database::getFirst('Language', Language::class, '*', [
            'languageIdentifier' => "languageIdentifier = $languageId"
        ]);
    }

    /**
     * Enregistrer les modifications du langage
     *
     * @param Language $entity
     *
     * @return bool
     */
    public static function edit(Language &$entity): bool {
        return Database::edit('Language', $entity);
    }

    /**
     * Enregistrer la création du langage
     *
     * @param Language $entity
     *
     * @return bool
     * @throws NoIdOverwritingException
     */
    public static function create(Language &$entity): bool {
        return Database::create('Language', $entity);
    }

    /**
     * Suppression du langage
     *
     * @param Language $entity
     *
     * @return bool
     */
    public static function remove(Language $entity): bool {
        return Database::remove('Language', $entity);
    }

}