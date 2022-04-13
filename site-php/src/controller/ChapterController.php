<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\Chapter;
use WebtoonLike\Site\entities\EntityInterface;
use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\entities\Webtoon;
use WebtoonLike\Site\utils\Database;

class ChapterController
{
    /**
     * Obtenir la liste des chapter
     *
     * @param string|array $col
     * @param array $where
     *
     * @return array
     */
    public static function getAll(string|array $col = '*', array $where = []): array
    {
        return Database::getAll('Chapter', Chapter::class, $col, $where);
    }

    /**
     * Retourne la liste des chapitres pour un Webtoon donnée
     *
     * @param int $webtoonId
     * @param string|array $col
     * @return array
     */
    public static function getAllForWebtoon(int $webtoonId, string|array $col = '*'): array {
        return Database::getAll('Chapter', Chapter::class, $col, ['webtoonID' => "webtoonID = $webtoonId"]);
    }

    /**
     * Obtention du chapter avec l'identifiant correspondant.
     *
     * @param int $id Identifiant recherché
     * @return Chapter|null
     */
    public static function getById(int $id): ?Chapter
    {
        return Database::getFirst('Chapter', Chapter::class, '*', ['chapterID' => "chapterID = $id"]);
    }

    /**
     * Obtention du chapter avec l'identifiant correspondant.
     *
     * @param int $index index recherché
     * @return EntityInterface
     */
    public static function getByIndex(Webtoon $webtoonID, int $index):  ?Chapter
    {
        return Database::getFirst('Chapter', Chapter::class, '*', [
            'index,webtoonID' => "index = $index AND webtoonID' = $webtoonID"
            ]);
    }

    /**
     * La ressource fournit existe-t-elle ?
     *
     * @param int $id Ressource correspondante
     * @return bool
     */
    public static function exists(int $id): bool {
        $q = "SELECT chapterID FROM Chapter WHERE chapterID = $id";
        $res = Database::getDB()->query($q)->fetch_assoc();
        return sizeof($res ?? []) > 0;
    }

    /**
     * Enregistre un chapter et retourne son identifiant ou <code>false</code> en cas d'erreur.
     *
     * @param Chapter $entity
     * @return int|false Faux en cas d'erreur
     */
    public static function create(Chapter &$entity): int|false
    {
        return Database::create('Chapter', $entity);
    }

    /**
     * Modifie le chapter
     *
     * @param Chapter $entity Le chapter modifié
     * @return bool Retourne vrai si la modification a été effectuée avec succès.
     */
    public static function edit(Chapter &$entity): bool
    {
        return Database::edit('Chapter', $entity);
    }

    /**
     * Supprime le chapter correspondant à l'identifiant fournit.
     *
     * @param Chapter $entity L'identifiant du chapter à supprimer.
     * @return bool Retourne vrai si la suppression a été effectuée avec succès.
     */
    public static function remove(Chapter $entity): bool
    {
        return Database::remove('Chapter', $entity);
    }
}