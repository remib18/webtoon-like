<?php

namespace WebtoonLike\Site\features\Translation\APIs;

use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\features\Translation\Result;

interface OCRInterface
{

    public function registerImage(Image $image): OCRInterface;

    public function runOCR(): Result;

}