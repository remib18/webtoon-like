<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\utils\Database;

class ChapterController extends AbstractController
{

    public static function existsById(int $id): bool {
        $q = Database::getDB()->query('SELECT chapterId FROM Chapter WHERE chapterId = ' . $id . ';');
        return sizeof($q->fetch_assoc()) > 0;
    }

    public static function exists(int $webtoonId, int $chapterIndex): false | int {
        $sql = 'SELECT chapterID ';
        $sql .= 'FROM Webtoon INNER JOIN Chapter USING (webtoonID)';
        $sql .= "WHERE webtoonID = $webtoonId AND number = $chapterIndex;";
        $q = Database::getDB()->query($sql);
        return $q->fetch_assoc()[0]['chapterID'] ?? false;
    }

    /**
     * @param int $chapterId
     * @return array<int, Image> Liste des images indexées par leur position
     */
    public static function getAllImages(int $chapterId): array {

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