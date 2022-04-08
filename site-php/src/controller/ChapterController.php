<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\Chapter;
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
    public function getByName(string $name): Chapter
    {
        // TODO: Implement getByName() method.
    }

    /**
     * @inheritDoc
     */
    public function create(Chapter $entity): int|false
    {
        $sql = 'INSERT INTO Chapter (number, title, webtoonID) VALUE (?, ?, ?);';
        $stmt = Database::getDB()->prepare($sql);
        $stmt->bind_param('isi', $entity['number'], $entity['title'], $entity['webtoonId']);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }

    /**
     * @inheritDoc
     */
    public function edit(Chapter $entity): bool
    {
        // TODO: Implement edit() method.
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): Chapter
    {
        // TODO: Implement getById() method.
    }

    /**
     * @inheritDoc
     */
    public function removeById(int $id): bool
    {
        // TODO: Implement removeById() method.
    }
}