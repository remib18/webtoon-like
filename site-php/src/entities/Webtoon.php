<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;

class Webtoon implements EntityInterface
{

    private ?int $id;

    public function __construct(
        ?int $webtoonID,
        private string $name,
        private string $author,
        private string $description
    ) {
        $this->id = $webtoonID;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    #[ArrayShape(['id' => "int", 'name' => "string", 'author' => "string", 'description' => "string"])]
    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'author' => $this->author,
            'description' => $this->description
        ];
    }

    public static function getColumnsKeys(): array {
        return [
            'webtoonID',
            'name',
            'author',
            'description'
        ];
    }
}