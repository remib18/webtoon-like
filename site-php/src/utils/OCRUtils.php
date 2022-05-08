<?php

namespace WebtoonLike\Site\utils;

use Google\Cloud\Vision\V1\Vertex;
use JetBrains\PhpStorm\Pure;
use WebtoonLike\Site\entities\Block;
use WebtoonLike\Site\features\Translation\Result\Bloc;
use WebtoonLike\Site\features\Translation\Result\Position;

class OCRUtils
{

    #[Pure] public static function proximityChecks(Block $bloc1, Block $bloc2, int $fontSize): bool
    {
        return (
            abs($bloc1->getStartY() - $bloc2->getEndY()) < $fontSize - 2
            && abs($bloc1->getStartX() - $bloc2->getEndX()) < $fontSize * 5
        );
    }

}