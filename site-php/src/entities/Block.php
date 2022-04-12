<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Block implements EntityInterface
{

    public function __construct(
        private int $id,
        private int $imageId,
        private int $startPositionId,
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
    public function getStartPositionId(): int
    {
        return $this->startPositionId;
    }

    /**
     * @param int $startPositionId
     */
    public function setStartPositionId(int $startPositionId): void
    {
        $this->startPositionId= $startPositionId;
    }

    #[ArrayShape(['id' => "int", 'imageId' => "int", 'startPositionId' => "int"])]
    public function __toArray(): array {
        return [
            'id' => $this->id,
            'imageId' => $this->imageId,
            'startPositionId' => $this->startPositionId
        ];
    }

}