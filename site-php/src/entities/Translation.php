<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;

class Translation
{
    public function __construct(
        private int $languageId,
        private string $blockId,
        private string $content
    ) {}

    /**
     * @return int
     */
    public function getLanguageId(): int
    {
        return $this->languageId;
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

    #[ArrayShape(['languageId' => "int", 'blockId' => "string", 'content' => "string"])]
    public function __toArray(): array {
        return [
            'languageId' => $this->languageId,
            'blockId' => $this->blockId,
            'content' => $this->content
        ];
    }
}