<?php

namespace WebtoonLike\Site\utils;

use Google\Cloud\Vision\V1\Vertex;
use JetBrains\PhpStorm\Pure;
use WebtoonLike\Site\features\Translation\Result\Bloc;
use WebtoonLike\Site\features\Translation\Result\Position;

class OCRUtils
{

    #[Pure] public static function vertexToPosition(Vertex $vertex): Position {
        return new Position(
            $vertex->getX(),
            $vertex->getY()
        );
    }

    #[Pure] public static function proximityChecks(Bloc $bloc1, Bloc $bloc2, int $fontSize): bool {
        return (
            abs($bloc1->getStart()->getY() - $bloc2->getEnd()->getY()) < $fontSize - 2
            && abs($bloc1->getStart()->getX() - $bloc2->getEnd()->getX()) < $fontSize * 5
        );
    }

}