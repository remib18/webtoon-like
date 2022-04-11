<?php

namespace WebtoonLike\Site\features\Translation\OCR;

use WebtoonLike\Site\entities\Position;
use WebtoonLike\Site\features\Translation\Result\Size;

interface NormalizedOCRResponseInterface
{

    public function getWord(): string;

    public function getBlocPos(): Position;

    public function getBlocSize(): Size;

}