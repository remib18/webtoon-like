<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;

class Webtoon implements EntityInterface
{
    private int $id;
    private string $name;
    private string $author;
    private string $description;

    function __construct($id, $name, $author, $description) {
        $this->id = $id;
        $this->name = $name;
        $this->author = $author;
        $this->description = $description;
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
}