<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use WebtoonLike\Site\controller\WebtoonController;

class Chapter implements EntityInterface
{

    public function __construct(
        private int $id,
        private int $number,
        private string $title,
        private int $webtoonId
    ){}

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
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

    #[Pure] #[ArrayShape(['id' => "int", 'number' => "mixed", 'title' => "string", 'webtoonId' => "int"])]
    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'title' => $this->title,
            'webtoonId' => $this->webtoonId
        ];
    }
}