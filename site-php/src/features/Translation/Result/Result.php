<?php

namespace WebtoonLike\Site\features\Translation\Result;

use WebtoonLike\Site\entities\Block;
use WebtoonLike\Site\entities\Language;

class Result
{

    /** @var array<Block> $blocks */
    private array $blocks = [];

    /** @var int $fontSize in pixels */
    private int $fontSize;

    /**
     * @param string|null $imagePath Le chemin de l'image à partir du dossier de webtoons. Null si une image manque
     * @param ?Language $originalLanguage Le langage d'origine de l'image, null si inconnu.
     */
    public function __construct(
        private ?string $imagePath,
        private ?Language $originalLanguage
    ) {}

    /**
     * @param Block $block
     * @return void
     */
    public function appendBlock(Block $block): void {
        $this->blocks[] = $block;
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
     * @return Block[]
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * @return int
     */
    public function getFontSize(): int
    {
        return $this->fontSize;
    }

    /**
     * @param Block[] $blocs
     */
    public function setBlocks(array $blocs): void
    {
        $this->blocks = $blocs;
    }

    /**
     * @return Language|null
     */
    public function getOriginalLanguage(): ?Language {
        return $this->originalLanguage;
    }

    public function setTranslations(array $translations, Language $target): void {
        foreach ($this->blocks as $block) {
            $block->registerTranslation($target->getIdentifier(), $translations[$block->getId()]);
        }
    }

}