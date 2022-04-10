<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\Webtoon;
use WebtoonLike\Site\utils\Database;

class WebtoonController extends \WebtoonLike\Site\controller\AbstractController
{

    /**
     * La ressource fournit existe-t-elle ?
     *
     * @param int $id Ressource correspondante
     * @return bool
     */
    public static function exists(int $id): bool {
        $q = Database::getDB()->query('SELECT webtoonId FROM Webtoon WHERE webtoonId = ' . $id . ';');
        return sizeof($q->fetch_assoc()) > 0;
    }

    /**
     * @inheritDoc
     */
    public static function getByName(string $name): Webtoon
    {
        // TODO: Implement getByName() method.
    }

    /**
     * @inheritDoc
     */
    public static function create(Webtoon $entity): int|false
    {
        // TODO: Implement create() method.
    }

    /**
     * @inheritDoc
     */
    public static function edit(Webtoon $entity): bool
    {
        // TODO: Implement edit() method.
    }

    /**
     * @inheritDoc
     */
    public static function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @inheritDoc
     */
    public static function getById(int $id): Webtoon
    {
        // TODO: Implement getById() method.
    }

    /**
     * @inheritDoc
     */
    public static function removeById(int $id): bool
    {
        // TODO: Implement removeById() method.
    }
}