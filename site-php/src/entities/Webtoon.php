<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;

class Webtoon implements EntityInterface
{

    private array $fieldsToSave = [];

    private ?int $id;
    private string $name;
    private string $author;
    private string $description;

    public function __construct(
        ?int $webtoonID,
        string $name,
        string $author,
        string $description
    ) {
        $this->id = $webtoonID;
        $this->setName($name);
        $this->setAuthor($author);
        $this->setDescription($description);
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
        $this->fieldsToSave['author'] = $author;
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
        $this->fieldsToSave['description'] = $description;
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
        $this->fieldsToSave['name'] = $name;
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([
        'webtoonID' => "int",
        'name' => "string",
        'author' => "string",
        'description' => "string"
    ])]
    public function __toArray(): array
    {
        return [
            'webtoonID' => $this->id,
            'name' => $this->name,
            'author' => $this->author,
            'description' => $this->description
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getColumnsKeys(): array
    {
        return ['webtoonID', 'name', 'author', 'description'];
    }

    /**
     * @inheritDoc
     */
    public static function getIdentifiers(): array
    {
        return ['webtoonID'];
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
    #[ArrayShape([
        'webtoonID' => "string",
        'name' => "string",
        'author' => "string",
        'description' => "string"
    ])]
    public static function getTypes(): array
    {
        return [
            'webtoonID' => 'integer',
            'name' => 'string',
            'author' => 'string',
            'description' => 'string'
        ];
    }
}