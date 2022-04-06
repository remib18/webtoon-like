<?php

namespace WebtoonLike\Site\controller;

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
    public function getByName(string $name): mixed
    {
        // TODO: Implement getByName() method.
    }

    /**
     * @inheritDoc
     */
    public function create(array $params): int|false
    {
        // TODO: Implement create() method.
    }

    /**
     * @inheritDoc
     */
    public function edit(int $id, array $params): bool
    {
        // TODO: Implement edit() method.
    }
}