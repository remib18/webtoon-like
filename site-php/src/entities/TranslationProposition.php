<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use WebtoonLike\Site\utils\DataTesting\DataField;
use WebtoonLike\Site\utils\DataTesting\DataType;

class TranslationProposition implements EntityInterface
{

    private array $fieldsToSave = [];

    private ?int $id;
    private string $proposedTranslation;
    private int $blockId;
    private int $userId;

    public function __construct(
        ?int   $translationPropositionID,
        string $proposedTranslation,
        int    $blockID,
        int    $userID,
        bool   $fromDB = true
    )
    {
        $this->id = $translationPropositionID;
        $this->setProposedTranslation($proposedTranslation);
        $this->setBlockId($blockID);
        $this->setUserId($userID);

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
    public function getProposedTranslation(): string
    {
        return $this->proposedTranslation;
    }

    /**
     * @param string $proposedTranslation
     */
    public function setProposedTranslation(string $proposedTranslation): void
    {
        $this->fieldsToSave['proposedTranslation'] = $proposedTranslation;
        $this->proposedTranslation = $proposedTranslation;
    }

    /**
     * @return int
     */
    public function getBlockId(): int
    {
        return $this->blockId;
    }

    /**
     * @param int $blockId
     */
    public function setBlockId(int $blockId): void
    {
        $this->fieldsToSave['blockID'] = $blockId;
        $this->blockId = $blockId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->fieldsToSave['userID'] = $userId;
        $this->userId = $userId;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([
        'translationPropositionID' => "int",
        'proposedTranslation' => "string",
        'blockID' => "int",
        'userID' => "int"
    ])]
    public function __toArray(): array
    {
        return [
            'translationPropositionID' => $this->id,
            'proposedTranslation' => $this->proposedTranslation,
            'blockID' => $this->blockId,
            'userID' => $this->userId
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getColumnsKeys(): array
    {
        return [
            'translationPropositionID',
            'proposedTranslation',
            'blockID',
            'userID'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getIdentifiers(): array
    {
        return ['translationPropositionID'];
    }

    /**
     * @inheritDoc
     */
    public function getTypes(): array
    {
        return [
            'translationPropositionID' => new DataField($this->id, DataType::int, true),
            'proposedTranslation' => new DataField($this->proposedTranslation, DataType::string),
            'blockID' => new DataField($this->blockId, DataType::int),
            'userID' => new DataField($this->userId, DataType::int)
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
    public function setId(int $id): void
    {
        if (!is_null($this->id)) throw new NoIdOverwritingException();
        $this->id = $id;
    }
}