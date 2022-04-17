<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use WebtoonLike\Site\controller\WebtoonController;

class Chapter implements EntityInterface
{

    private array $fieldsToSave = [];

    private ?int $id;
    private int $index;
    private string $title;
    private int $webtoonId;

    public function __construct(
        ?int $chapterID,
        int $index,
        string $title,
        int $webtoonID,
        bool $fromDB = true
    ) {
        $this->id = $chapterID;
        $this->setIndex($index);
        $this->setTitle($title);
        $this->setWebtoonId($webtoonID);

        if ($fromDB) $this->AllFieldsSaved();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $index
     */
    public function setIndex(int $index): void
    {
        $this->fieldsToSave['index'] = $index;
        $this->index = $index;
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->fieldsToSave['title'] = $title;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param int $webtoonId
     */
    public function setWebtoonId(int $webtoonId): void
    {
        $this->fieldsToSave['webtoonID'] = $webtoonId;
        $this->webtoonId = $webtoonId;
    }

    /**
     * @return int
     */
    public function getWebtoonId(): int
    {
        return $this->webtoonId;
    }

    /**
     * @return Webtoon
     */
    public function getWebtoon(): Webtoon
    {
        return WebtoonController::getById($this->webtoonId);
    }

    /**
     * @inheritDoc
     */
    #[Pure] #[ArrayShape([
        'chapterID' => "int",
        'index' => "mixed",
        'title' => "string",
        'webtoonID' => "int"
    ])]
    public function __toArray(): array
    {
        return [
            'chapterID' => $this->id,
            'index' => $this->index,
            'title' => $this->title,
            'webtoonID' => $this->webtoonId
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getColumnsKeys(): array {
        return [
            'chapterID',
            'index',
            'title',
            'webtoonID'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getIdentifiers(): array
    {
        return ['chapterID'];
    }

    /**
     * @inheritDoc
     */
    public static function getTypes(): array
    {
        return [
            'chapterID' => "int",
            'index' => "mixed",
            'title' => "string",
            'webtoonID' => "int"
        ];
    }

    /**
     * @inheritDoc
     */
    public function getFieldsToSave(): array
    {
        return $this->fieldsToSave;
    }

    /**
     * @inheritDoc
     */
    public function AllFieldsSaved(): void
    {
        $this->fieldsToSave = [];
    }

    /**
     * @inheritDoc
     */
    public function setId(int $id): void {
        if (!is_null($this->id)) throw new NoIdOverwritingException();
        $this->id = $id;
    }
}