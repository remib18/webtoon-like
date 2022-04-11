<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Block implements EntityInterface
{

    public function __construct(
        private int $id,
        private int $imageId,
        private int $cellPositionId,
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
    public function getCellPositionId(): int
    {
        return $this->cellPositionId;
    }

    /**
     * @param int $cellPositionId
     */
    public function setCellPositionId(int $cellPositionId): void
    {
        $this->cellPositionId= $cellPositionId;
    }

    #[ArrayShape(['id' => "int", 'imageId' => "int", 'cellPositionId' => "int"])]
    public function __toArray(): array {
        return [
            'id' => $this->id,
            'imageId' => $this->imageId,
            'cellPositionId' => $this->cellPositionId
        ];
    }

}