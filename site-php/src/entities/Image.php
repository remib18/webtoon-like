<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Image implements EntityInterface
{

    public function __construct(
        private int $id,
        private int $index,
        private string $path,
        private int $chapterId
    ) {}

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getIndex(): int {
        return $this->index;
    }

    /**
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getChapterId(): int
    {
        return $this->chapterId;
    }

    /**
     * @return array<string, mixed>
     */
    #[Pure]
    #[ArrayShape([
        'imageId' => "int",
        'index' => "int",
        'path' => "string",
        'chapterId' => "int"
    ])]
    public function __toArray(): array
    {
        return [
            'imageId' => $this->id,
            'index' => $this->index,
            'path' => $this->path,
            'chapterId' => $this->chapterId
        ];
    }

    /**
     * Obtenir le code source de l'image
     *
     * @return string
     */
    public function getBinaryCode(): string
    {
        /*
         * TODO:
         * 1. Déterminer si la source de l'image est url ou fichier (
         *     Commence soit par 'http://' / 'https://' / 'file://'
         * 2. En fonction de la méthode, récupérer le fichier et le lire (file_read)
         */
    }
}