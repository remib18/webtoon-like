<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class TranslationProposition implements EntityInterface
{

    public function __construct(
        private int $id,
        private string $proposedTranslation,
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

    #[ArrayShape(['id' => "int", 'proposedTranslation' => "string"])]
    public function __toArray(): array {
        return [
            'id' => $this->id,
            'proposedTranslation' => $this->proposedTranslation
        ];
    }

}