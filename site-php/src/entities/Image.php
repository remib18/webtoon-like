<?php

namespace WebtoonLike\Site\entities;

class Image implements EntityInterface
{

    public function getId(): int {
        return 0;
    }

    public function getIndex(): int {
        return 0;
    }

    public function getImageSrc(): string {
        return '';
    }

    public function getOriginalLanguage(): Language {
        return new Language();
    }

    /**
     * @return array<Language>
     */
    public function getAlreadyTranslatedLanguages(): array {
        return [];
    }

    public function __toArray(): array
    {
        // TODO: Implement __toArray() method.
        return [];
    }
}