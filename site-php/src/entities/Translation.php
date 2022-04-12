<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;

class Translation
{
    public function __construct(
        private int $identifier,
        private string $blockId,
        private string $content
    ) {}

    /**
     * @return int
     */
    public function getIdentifier(): int
    {
        return $this->identifier;
    }

    /**
     * @param int $identifier
     */
    public function setIdentifier(int $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
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
     * @param string $blockId
     */
    public function setBlockId(string $blockId): void
    {
        $this->blockId = $blockId;
    }

    /**
     * @return string
     */
    public function getBlockId(): string
    {
        return $this->blockId;
    }

    /**
     * @param int $languageId
     */
    public function setLanguageId(int $languageId): void
    {
        $this->languageId = $languageId;
    }

    #[ArrayShape(['identifier' => "int", 'blockId' => "string", 'content' => "string"])]
    public function __toArray(): array {
        return [
            'identifier' => $this->identifier,
            'blockId' => $this->blockId,
            'content' => $this->content
        ];
    }
}