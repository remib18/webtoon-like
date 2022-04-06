<?php

namespace WebtoonLike\Site\entities;

class Image implements EntityInterface
{

    public function getId(): int {

    }

    public function getIndex(): int {

    }

    public function getImageSrc(): string {

    }

    public function getOriginalLanguage(): Language {

    }

    /**
     * @return array<Language>
     */
    public function getAlreadyTranslatedLanguages(): array {

    }

    public function __toArray(): array
    {
        // TODO: Implement __toArray() method.
    }
}