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

    /**
     * Obtenir le code source de l'image
     *
     * @return string
     */
    public function getImage(): string
    {
        /*
         * TODO:
         * 1. Déterminer si la source de l'image est url ou fichier (
         *     Commence soit par 'http://' / 'https://' / 'file://'
         * 2. En fonction de la méthode, récupérer le fichier et le lire (file_read)
         */
    }
}