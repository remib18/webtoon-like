<?php

namespace WebtoonLike\Site\features\Translation\OCR\Result;

use WebtoonLike\Site\entities\Position;
use WebtoonLike\Site\features\Translation\Result\Size;

class Bubble
{

    public function __construct(
        private string $text,
        private Position $position,
        private Size $size
    ) {}

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    /**
     * @return Size
     */
    public function getSize(): Size
    {
        return $this->size;
    }

}