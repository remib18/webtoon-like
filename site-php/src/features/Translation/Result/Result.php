<?php

namespace WebtoonLike\Site\features\Translation\Result;

use WebtoonLike\Site\entities\Block;
use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\exceptions\TranslationException;

class Result
{

    /** @var Block[] $blocks */
    private array $blocks = [];

    /** @var Block[] $mappedBlocks Liste des blocks indexer par leur identifiant */
    private array $mappedBlocks = [];

    /** @var int $fontSize in pixels */
    private int $fontSize;

    private string $preferredStruct = 'blocks';

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
        if (is_null($block->getId())) {
            $this->blocks[] = $block;
        } else {
            $this->preferredStruct = 'mappedBlocks';
            $this->mappedBlocks[$block->getId()] = $block;
        }
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
        return $this->{$this->preferredStruct};
    }

    /**
     * @return int
     */
    public function getFontSize(): int
    {
        return $this->fontSize;
    }

    /**
     * @param Block[] $blocks
     */
    public function setBlocks(array $blocks, bool $mapped): void
    {
        if ($mapped) {
            $this->mappedBlocks = $blocks;
            $this->preferredStruct = 'mappedBlocks';
        } else {
            $this->blocks = $blocks;
        }
    }

    /**
     * @return Language|null
     */
    public function getOriginalLanguage(): ?Language {
        return $this->originalLanguage;
    }

    /**
     * @param array    $translations
     * @param Language $target
     *
     * @return void
     * @throws TranslationException
     */
    public function setTranslations(array $translations, Language $target): void {
        foreach ($translations as $blockId => $translation) {
            $this->setTranslationForBlock($blockId, $translation, $target->getIdentifier());
        }
    }

    /**
     * @param int    $id
     * @param string $translation
     * @param string $languageId
     *
     * @return void
     * @throws TranslationException
     */
    private function setTranslationForBlock(int $id, string $translation, string $languageId): void {
        if (isset($this->mappedBlocks[$id])) {
            $this->mappedBlocks[$id]->registerTranslation($languageId, $translation);
            return;
        }
        foreach ($this->blocks as $block) {
            if ($block->getId() === $id) {
                $block->registerTranslation($languageId, $translation);
                return;
            }
        }
        throw new TranslationException('Unable to register translation on block ' . $id . '.');
    }

    public function __toArray(): array {
        $blocks = [];
        foreach (( $this->mappedBlocks ?? $this->blocks ?? [] ) as $block) {
            $blocks[] = $block->__toArray();
        }
        return [
            'font-size'  => $this->fontSize,
            'image'      => $this->imagePath,
            'image-lang' => $this->originalLanguage->__toArray(),
            'blocks'     => $blocks,
        ];
    }

}