<?php

namespace WebtoonLike\Site\features\Translation\OCR;

use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\exceptions\ApiException;
use WebtoonLike\Site\features\Translation\Result\Result;

interface OCRInterface
{

    /**
     * @param Image $image L'image à charger
     * @return $this
     */
    public function registerImage(Image $image): OCRInterface;

    /**
     * @return array<Result>
     *
     * @throws ApiException
     */
    public function runOCR(): array;

}