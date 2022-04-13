<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\exceptions\UnImplementedMethodException;
use WebtoonLike\Site\utils\Database;

class ImageController
{

    /**
     * @inheritDoc
     */
    public static function getAll(): array
    {
        $q = 'SELECT * FROM `Image`;';
        $res = Database::getDB()
            ->query($q)
            ->fetch_all(MYSQLI_ASSOC);
        return Database::responseToObjects($res, Image::class);
    }

    /**
     * @inheritDoc
     */
    public static function getById(int $id): Image
    {
        $q = "SELECT * FROM `Image` WHERE imageID = $id;";
        $res = Database::getDB()
            ->query($q)
            ->fetch_all(MYSQLI_ASSOC);
        return Database::responseToObjects($res, Image::class)[0];
    }

    /**
     * @inheritDoc
     * @throws UnImplementedMethodException
     */
    public static function getByName(string $name): Image
    {
        throw new UnImplementedMethodException();
    }

    /**
     * @inheritDoc
     */
    public static function create(Image $entity): int|false
    {
        $q = 'INSERT INTO Image(`index`, `path`, needOCR, chapterID) VALUE (?, ?, ?, ?);';
        $req = Database::getDB()->prepare($q);
        $req->bind_param('isii',
                $index,
                $path,
                $doesNeedOCR,
                $chapterId
            );
        $index = $entity->getIndex();
        $path = $entity->getPath();
        $doesNeedOCR = $entity->doesNeedOCR();
        $chapterId = $entity->getChapterId();
        $res = $req->execute();
        var_dump($res);
        if (!$res) return false;
        return 1;
    }

    /**
     * @inheritDoc
     */
    public static function edit(Image $entity): bool
    {
        // TODO: Implement edit() method.
    }

    /**
     * @inheritDoc
     */
    public static function removeById(int $id): bool
    {
        // TODO: Implement removeById() method.
    }
}