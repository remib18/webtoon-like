<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\Block;
use WebtoonLike\Site\entities\Chapter;
use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\entities\NoIdOverwritingException;
use WebtoonLike\Site\utils\Database;

class ImageController
{
    /**
     * Obtenir la liste des images
     *
     * @param string|array $col
     * @param array $where
     *
     * @return Image[]
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
     * @param Chapter $chapterID
     * @param int     $index index recherché
     *
     * @return Image|null
     */
    public static function getByIndex(Chapter $chapterID, int $index): ?Image
    {
        return Database::getFirst('Chapter', Chapter::class, '*', [
            'index,chapterID' => "index = $index AND chapterID' = $chapterID"
        ]);
    }

    /**
     * Obtention de tous les blocs d'une image
     *
     * @param int $id Identifiant de l'image
     *
     * @return Block[]
     */
    public static function getBlocks(int $id): array {
        return Database::getAll('Block', Block::class, '*', ['imageID' => "imageID = $id"]);
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
     *
     * @return bool Faux en cas d'erreur
     *
     * @throws NoIdOverwritingException
     */
    public static function create(Image &$entity): bool
    {
        return Database::create('Image', $entity);
    }

    /**
     * Enregistre des images ou <code>false</code> en cas d'erreur.
     *
     * @param array $entity
     *
     * @return bool Faux en cas d'erreur
     *
     * @throws NoIdOverwritingException
     */
    public static function createBatch(array &$entity): bool
    {
        return Database::createBatch('Image', $entity);
    }

    /**
     * Modifie l'image
     *
     * @param Image $entity L'image modifiée
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