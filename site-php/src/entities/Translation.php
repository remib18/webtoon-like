<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;

class Translation
{
    public function __construct(
        private int $id,
        private string $blockId,
        private string $content
    ) {}

    /**
     * @return string
     */
    public function getBlockId(): string
    {
        return $this->blockId;
    }

    /**
     * @param string $blockId
     */
    public function setBlockId(string $blockId): void
    {
        $this->blockId = $blockId;
    }

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
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    #[ArrayShape(['id' => "int", 'blockId' => "string", 'content' => "string"])]
    public function __toArray(): array {
        return [
            'id' => $this->id,
            'blockId' => $this->blockId,
            'content' => $this->content
        ];
    }
}