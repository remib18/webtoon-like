<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\EntityInterface;
use WebtoonLike\Site\entities\Webtoon;
use WebtoonLike\Site\utils\Database;

class WebtoonController
{

    /**
     * Obtenir la liste des webtoons
     *
     * @param string|array $col
     * @param array $where
     *
     * @return array
     */
    public static function getAll(string|array $col = '*', array $where = []): array
    {
        return Database::getAll('Webtoon', Webtoon::class, $col, $where);
    }

    /**
     * Obtention du webtoon avec l'identifiant correspondant.
     *
     * @param int $id Identifiant rechercher
     * @return Webtoon|null
     */
    public static function getById(int $id): ?Webtoon
    {
        return Database::getFirst('Webtoon', Webtoon::class, '*', ['webtoonID' => "webtoonID = $id"]);
    }

    /**
     * Obtention du webtoon avec le nom correspondant.
     *
     * @param string $name Nom rechercher
     * @return EntityInterface[]
     */
    public static function getByName(string $name): array
    {
        return Database::getAll('Webtoon', Webtoon::class, '*', ['name' => "name = '$name'"]);
    }

    /**
     * La ressource fournit existe-t-elle ?
     *
     * @param int $id Ressource correspondante
     * @return bool
     */
    public static function exists(int $id): bool {
        $q = "SELECT webtoonID FROM Webtoon WHERE webtoonID = $id";
        $res = Database::getDB()->query($q)->fetch_assoc();
        return sizeof($res ?? []) > 0;
    }

    /**
     * Enregistre un webtoon et retourne son identifiant ou <code>false</code> en cas d'erreur.
     *
     * @param Webtoon $entity
     * @return int|false Faux en cas d'erreur
     */
    public static function create(Webtoon &$entity): int|false
    {
        return Database::create('Webtoon', $entity);
    }

    /**
     * Modifie le webtoon
     *
     * @param Webtoon $entity Le webtoon modifié
     * @return bool Retourne vrai si la modification a été effectuée avec succès.
     */
    public static function edit(Webtoon &$entity): bool
    {
        return Database::edit('Webtoon', $entity);
    }



    /**
     * Supprime le webtoon correspondant à l'identifiant fournit.
     *
     * @param Webtoon $entity L'identifiant du webtoon à supprimer.
     * @return bool Retourne vrai si la suppression a été effectuée avec succès.
     */
    public static function remove(Webtoon $entity): bool
    {
        return Database::remove('Webtoon', $entity);
    }
}