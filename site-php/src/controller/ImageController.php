<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\Chapter;
use WebtoonLike\Site\entities\EntityInterface;
use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\utils\Database;

class ImageController
{
    /**
     * Obtenir la liste des image
     *
     * @param string|array $col
     * @param array $where
     *
     * @return array
     */
    public static function getAll(string|array $col = '*', array $where = []): array
    {
        return Database::getAll('Image', Image::class, $col, $where);
    }

    /**
     * Obtention de l'image avec l'identifiant correspondant.
     *
     * @param int $id Identifiant recherché
     * @return Image|null
     */
    public static function getById(int $id): ?Image
    {
        return Database::getFirst('Image', Image::class, '*', ['imageID' => "imageID = $id"]);
    }

    /**
     * Obtention de l'image avec l'identifiant correspondant (index, chapterId)
     *
     * @param int $index index recherché
     * @return EntityInterface
     */
    public static function getByIndex(Chapter $chapterID, int $index):  ?Image
    {
        return Database::getFirst('Chapter', Chapter::class, '*', [
            'index,chapterID' => "index = $index AND chapterID' = $chapterID"
        ]);
    }

    /**
     * La ressource fournit existe-t-elle ?
     *
     * @param int $id Ressource correspondante
     * @return bool
     */
    public static function exists(int $id): bool {
        $q = "SELECT imageID FROM Image WHERE imageID = $id";
        $res = Database::getDB()->query($q)->fetch_assoc();
        return sizeof($res ?? []) > 0;
    }

    /**
     * Enregistre une image et retourne son identifiant ou <code>false</code> en cas d'erreur.
     *
     * @param Image $entity
     * @return int|false Faux en cas d'erreur
     */
    public static function create(Image &$entity): int|false
    {
        return Database::create('Image', $entity);
    }

    /**
     * Modifie l'image
     *
     * @param Image $entity L'image modifié
     * @return bool Retourne vrai si la modification a été effectuée avec succès.
     */
    public static function edit(Image &$entity): bool
    {
        return Database::edit('Image', $entity);
    }

    /**
     * Supprime l'image correspondant à l'identifiant fournit.
     *
     * @param Image $entity L'identifiant de l'image à supprimer.
     * @return bool Retourne vrai si la suppression a été effectuée avec succès.
     */
    public static function remove(Image $entity): bool
    {
        return Database::remove('Image', $entity);
    }
}