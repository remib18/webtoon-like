<?php

namespace WebtoonLike\Site\features\Translation\OCR;

use Google\Cloud\Vision\V1\AnnotateImageResponse;
use WebtoonLike\Site\entities\Image;
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
     */
    public function runOCR(): array;

    /**
     * @param AnnotateImageResponse $response
     * @return array<NormalizedOCRResponseInterface>
     */
    public static function normalizeResponse(AnnotateImageResponse $response): array;

}