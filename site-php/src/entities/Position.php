<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Position implements EntityInterface
{

    public function __construct(
        private int $x,
        private int $y
    ) {}

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $x
     */
    public function setX(int $x): void
    {
        $this->x = $x;
    }

    /**
     * @param int $y
     */
    public function setY(int $y): void
    {
        $this->y = $y;
    }

    #[Pure] #[ArrayShape(['x' => "int", 'y' => "int"])]
    public function __toArray(): array
    {
        return [
            'x' => $this->x,
            'y' => $this->y
        ];
    }
}