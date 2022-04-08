<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;

class Chapter implements EntityInterface
{
    private int $id;
    private int $number;
    private string $title;
    private Webtoon $webtoon;

    function __construct($id, $number, $title, $webtoon) {
        $this->id = $id;
        $this->number = $number;
        $this->title = $title;
        $this->webtoon = $webtoon;
    }

    #[ArrayShape(['id' => "int", 'number' => "mixed", 'title' => "string", 'webtoonId' => "int"])]
    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            'number' => $this->name,
            'title' => $this->title,
            'webtoonId' => $this->webtoon->getId()
        ];
    }

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
     * @param Webtoon $webtoon
     */
    public function setWebtoon(Webtoon $webtoon): void
    {
        $this->webtoon = $webtoon;
    }

    /**
     * @return int
     */
    public function getWebtoon(): int
    {
        return $this->webtoon->getId();
    }
}