<?php

namespace WebtoonLike\Site\features\Translation\Result;

use WebtoonLike\Site\entities\Position;

class Bubble
{

    private string $translatedText;
    private string $translatedTextWithLineBreaks;

    public function __construct(
        private string   $originalText,
        private Position $position,
        private Size     $size
    ) {}

    /**
     * @return string
     */
    public function getOriginalText(): string
    {
        return $this->originalText;
    }

    /**
     * @return string
     */
    public function getTranslatedText(): string
    {
        return $this->translatedText;
    }

    /**
     * @return string
     */
    public function getFinalText(): string
    {
        return $this->translatedTextWithLineBreaks;
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    /**
     * @return Size
     */
    public function getSize(): Size
    {
        return $this->size;
    }

    /**
     * @param string $translatedText
     */
    public function setTranslatedText(string $translatedText): void
    {
        $this->translatedText = $translatedText;
    }

    /**
     * @param string $translatedTextWithLineBreaks
     */
    public function setTranslatedTextWithLineBreaks(string $translatedTextWithLineBreaks): void
    {
        $this->translatedTextWithLineBreaks = $translatedTextWithLineBreaks;
    }

}