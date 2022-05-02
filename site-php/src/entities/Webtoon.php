<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use WebtoonLike\Site\utils\DataTesting\DataField;
use WebtoonLike\Site\utils\DataTesting\DataType;

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
        string $description,
        bool $fromDB = true
    ) {
        $this->id = $webtoonID;
        $this->setName($name);
        $this->setAuthor($author);
        $this->setDescription($description);

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
    public function getTypes(): array
    {
        return [
            'webtoonID' => new DataField($this->id, DataType::int, true),
            'name' => new DataField($this->name, DataType::string, false, null, 256, null),
            'author' => new DataField($this->author, DataType::string, false, null, 128, null),
            'description' => new DataField($this->description, DataType::string)
        ];
    }

    /**
     * @inheritDoc
     */
    public function setId(int $id): void {
        if (!is_null($this->id)) throw new NoIdOverwritingException();
        $this->id = $id;
    }
}