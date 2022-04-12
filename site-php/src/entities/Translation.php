<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;

class Translation
{

    private int $blockId;

    public function __construct(
        private string    $languageIdentifier,
        int $blockID,
        private string $content
    ) {
        $this->blockId = $blockID;
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

    #[ArrayShape(['identifier' => "int", 'blockId' => "string", 'content' => "string"])]
    public function __toArray(): array {
        return [
            'identifier' => $this->languageIdentifier,
            'blockId' => $this->blockId,
            'content' => $this->content
        ];
    }

    public static function getColumnsKeys(): array {
        return [
            'languageIdentifier',
            'blockID',
            'content'
        ];
    }
}