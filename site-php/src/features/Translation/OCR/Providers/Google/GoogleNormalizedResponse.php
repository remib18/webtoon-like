<?php

namespace WebtoonLike\Site\features\Translation\OCR\Providers\Google;

use WebtoonLike\Site\entities\Position;
use WebtoonLike\Site\features\Translation\OCR\NormalizedOCRResponseInterface;
use WebtoonLike\Site\features\Translation\Result\Size;

class GoogleNormalizedResponse implements NormalizedOCRResponseInterface
{

    private Position $pos;
    private Size $size;

    public function __construct(
        private string $word,
        \Google\Cloud\Vision\V1\BoundingPoly $poly
    ) {
        $blocStartX = $poly->getVertices()[0]->getX();
        $blocStartY = $poly->getVertices()[0]->getY();
        $blocEndX = $poly->getVertices()[2]->getX();
        $blocEndY = $poly->getVertices()[2]->getY();

        $this->pos = new Position(
            $blocStartX,
            $blocStartY
        );

        $width = $blocEndX - $blocStartX;
        $height = $blocEndY - $blocStartY;

        $this->size = new Size($width, $height);
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getBlocPos(): Position
    {
        return $this->pos;
    }

    public function getBlocSize(): Size
    {
        return $this->size;
    }
}