<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use WebtoonLike\Site\controller\WebtoonController;

class Chapter implements EntityInterface
{
    private int $id;
    private int $webtoonId;

    public function __construct(
        int $chapterID,
        private int $index,
        private string $title,
        int $webtoonID
    ) {
        $this->id = $chapterID;
        $this->webtoonId = $webtoonID;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $index
     */
    public function setIndex(int $index): void
    {
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

    #[Pure] #[ArrayShape(['id' => "int", 'index' => "mixed", 'title' => "string", 'webtoonId' => "int"])]
    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            'index' => $this->index,
            'title' => $this->title,
            'webtoonId' => $this->webtoonId
        ];
    }
}