<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\Block;
use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\entities\NoIdOverwritingException;
use WebtoonLike\Site\utils\Database;

class BlockController
{

    /**
     * Obtenir tous les blocks dans l'image correspondante
     *
     * @param Image $image
     *
     * @return Block[]
     */
    public static function getAll(Image $image): array {
        $imgId = $image->getId();
        return Database::getAll('Block', Block::class, '*', ['ImageID' => "ImageID = $imgId"]);
    }

    /**
     * Obtenir le block avec l'identifiant correspondant
     *
     * @param int $id
     *
     * @return Block|null
     */
    public static function getById(int $id): ?Block {
        return Database::getFirst('Block', Block::class, '*', ['ImageID' => "ImageID = $id"]);
    }

    /**
     * Modifie le block correspondant
     *
     * @param Block $entity
     *
     * @return bool
     */
    public static function edit(Block &$entity): bool {
        return Database::edit('Block', $entity);
    }

    /**
     * Enregistre un nouveau block
     *
     * @param Block $entity
     *
     * @return bool
     *
     * @throws NoIdOverwritingException
     */
    public static function create(Block &$entity): bool {
        return Database::create('Block', $entity);
    }

    /**
     * Supprime le block
     *
     * @param Block $entity
     *
     * @return bool
     */
    public static function remove(Block $entity): bool {
        return Database::remove('Block', $entity);
    }

}