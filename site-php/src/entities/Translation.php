<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use WebtoonLike\Site\utils\DataTesting\DataField;
use WebtoonLike\Site\utils\DataTesting\DataType;

class Translation implements EntityInterface
{

    private array $fieldsToSave = [];

    private string $languageIdentifier;
    private int $blockId;
    private string $content;

    public function __construct(
        string $languageIdentifier,
        int $blockID,
        string $content,
        bool $fromDB = true
    ) {
        $this->languageIdentifier = $languageIdentifier;
        $this->blockId = $blockID;
        $this->setContent($content);

        if ($fromDB) $this->AllFieldsSaved();
        else { // No autogenerated ids
            $this->fieldsToSave['languageIdentifier'] = $languageIdentifier;
            $this->fieldsToSave['blockID'] = $blockID;
        }
    }

    /**
     * @return string
     */
    public function getLanguageIdentifier(): string
    {
        return $this->languageIdentifier;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->fieldsToSave['content'] = $content;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getBlockId(): string
    {
        return $this->blockId;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([
        'identifier' => "string",
        'blockId' => "int",
        'content' => "string"
    ])]
    public function __toArray(): array {
        return [
            'languageIdentifier' => $this->languageIdentifier,
            'blockId' => $this->blockId,
            'content' => $this->content
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getColumnsKeys(): array {
        return [
            'languageIdentifier',
            'blockID',
            'content'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getIdentifiers(): array
    {
        return ['languageIdentifier', 'blockID'];
    }

    /**
     * @inheritDoc
     */
    public function getTypes(): array
    {
        return [
            'languageIdentifier' => new DataField($this->languageIdentifier, DataType::string),
            'blockId' => new DataField($this->blockId, DataType::int),
            'content' => new DataField($this->content, DataType::string)
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