<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class TranslationProposition implements EntityInterface
{

    public function __construct(
        private int $id,
        private string $proposedTranslation,
        private int $blockId,
        private int $userId
    ) {}

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
    public function getProposedTranslation(): string
    {
        return $this->proposedTranslation;
    }

    /**
     * @param string $proposedTranslation
     */
    public function setProposedTranslation(string $proposedTranslation): void
    {
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
        $this->userId = $userId;
    }

    #[ArrayShape(['id' => "int", 'proposedTranslation' => "string", 'blockId' => "int", 'userId' => "int"])]
    public function __toArray(): array {
        return [
            'id' => $this->id,
            'proposedTranslation' => $this->proposedTranslation,
            'blockId' => $this->blockId,
            'userId' => $this->userId
        ];
    }

}