<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use WebtoonLike\Site\utils\DataTesting\DataField;
use WebtoonLike\Site\utils\DataTesting\DataType;

class Language implements EntityInterface
{

    private array $fieldsToSave = [];

    private string $identifier;
    private string $name;

    public function __construct(
        string $identifier,
        string $name,
        bool $fromDB = true
    ){
        $this->identifier = $identifier;
        $this->setName($name);

        if ($fromDB) $this->AllFieldsSaved();
        else $this->fieldsToSave['identifier'] = $identifier; // Not generated field
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
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
        'identifier' => "string",
        'name' => "string"
    ])]
    public function __toArray(): array
    {
        return [
            'identifier' => $this->identifier,
            'name' => $this->name
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getColumnsKeys(): array {
        return [
            'identifier',
            'name'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getIdentifiers(): array
    {
        return ['identifier'];
    }

    /**
     * @inheritDoc
     */
    public function getTypes(): array
    {
        return [
            'identifier' => new DataField($this->identifier, DataType::string),
            'name' => new DataField($this->name, DataType::string)
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
    public function setId(int $id): void {}
}