<?php

namespace WebtoonLike\Site\features\Translation\Result;

class Result
{

    /** @var array<Bloc> $blocs */
    private array $blocs = [];

    /** @var int $fontSize in pixels */
    private int $fontSize;

    /**
     * @param string|null $imagePath Le chemin de l'image à partir du dossier de webtoons. Null si une image manque
     */
    public function __construct(
        private ?string $imagePath
    ) {}

    /**
     * @param Bloc $bloc
     * @return void
     */
    public function appendBloc(Bloc $bloc): void {
        $this->blocs[] = $bloc;
    }

    /**
     * @param int $fontSize
     */
    public function setFontSize(int $fontSize): void
    {
        $this->fontSize = $fontSize;
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    /**
     * @return Bloc[]
     */
    public function getBlocs(): array
    {
        return $this->blocs;
    }

    /**
     * @return int
     */
    public function getFontSize(): int
    {
        return $this->fontSize;
    }

    /**
     * @param Bloc[] $blocs
     */
    public function setBlocs(array $blocs): void
    {
        $this->blocs = $blocs;
    }

}