<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Block implements EntityInterface
{

    private ?int $id;
    private int $imageId;

    public function __construct(
        ?int $blockID,
        private string $originalContent,
        private int $startX,
        private int $startY,
        private int $endX,
        private int $endY,
        int $imageID
    ) {
        $this->id = $blockID;
        $this->imageId = $imageID;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
    public function getEndX(): int
    {
        return $this->endX;
    }

    /**
     * @param int $endX
     */
    public function setEndX(int $endX): void
    {
        $this->endX = $endX;
    }

    /**
     * @return int
     */
    public function getEndY(): int
    {
        return $this->endY;
    }

    /**
     * @param int $endY
     */
    public function setEndY(int $endY): void
    {
        $this->endY = $endY;
    }

    /**
     * @return string
     */
    public function getOriginalContent(): string
    {
        return $this->originalContent;
    }

    /**
     * @param string $originalContent
     */
    public function setOriginalContent(string $originalContent): void
    {
        $this->originalContent = $originalContent;
    }

    /**
     * @return int
     */
    public function getStartX(): int
    {
        return $this->startX;
    }

    /**
     * @param int $startX
     */
    public function setStartX(int $startX): void
    {
        $this->startX = $startX;
    }

    /**
     * @return int
     */
    public function getStartY(): int
    {
        return $this->startY;
    }

    /**
     * @param int $startY
     */
    public function setStartY(int $startY): void
    {
        $this->startY = $startY;
    }

    #[ArrayShape(['id' => "int",
        'startX' => "int",
        'startY' => "int",
        'endX' => "int",
        'endY' => "int",
        'originalContent' => "string",
        'imageId' => "int"])]
    public function __toArray(): array {
        return [
            'id' => $this->id,
            'startX' => $this->startX,
            'startY' => $this->startY,
            'endX' => $this->endX,
            'endY' => $this->endY,
            'originalContent' => $this->originalContent,
            'imageId' => $this->imageId
        ];
    }

}