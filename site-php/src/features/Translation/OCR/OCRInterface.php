<?php

namespace WebtoonLike\Site\features\Translation\OCR;

use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\features\Translation\Result;

interface OCRInterface
{

    public function registerImage(Image $image): OCRInterface;

    public function runOCR(): Result;

}