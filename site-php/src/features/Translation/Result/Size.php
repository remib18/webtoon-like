<?php

namespace WebtoonLike\Site\features\Translation\Result;

class Size
{

    public function __construct(
        private int $width,
        private int $height
    ) {}

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }


    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }
}