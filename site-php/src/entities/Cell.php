<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Cell implements EntityInterface
{

    public function __construct(
        private int $id,
        private string $content,
        private int $imageId,
        private int $chapterId,
        private int $languageId
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
     * @return int
     */
    public function getChapterId(): int
    {
        return $this->chapterId;
    }

    /**
     * @param int $chapterId
     */
    public function setChapterId(int $chapterId): void
    {
        $this->chapterId = $chapterId;
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

    /**
     * @return int
     */
    public function getImageId(): int
    {
        return $this->imageId;
    }

    /**
     * @param int $imageId
     */
    public function setImageId(int $imageId): void
    {
        $this->imageId = $imageId;
    }

    /**
     * @return int
     */
    public function getLanguageId(): int
    {
        return $this->languageId;
    }

    /**
     * @param int $languageId
     */
    public function setLanguageId(int $languageId): void
    {
        $this->languageId = $languageId;
    }

    #[ArrayShape(['id' => "int", 'content' => "string", 'imageId' => "int", 'chapterId' => "int", 'languageId' => "int"])]
    public function __toArray(): array {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'imageId' => $this->imageId,
            'chapterId' => $this->chapterId,
            'languageId' => $this->languageId,
        ];
    }

}