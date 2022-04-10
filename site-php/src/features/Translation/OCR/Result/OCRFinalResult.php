<?php

namespace WebtoonLike\Site\features\Translation\OCR\Result;

class OCRFinalResult
{



    /** @var array<Bubble> $bubbles */
    private array $bubbles = [];

    public function __construct(
        private string $imagePath
    ) {}

    public function appendBubble(Bubble $bubble): void {
        $this->bubbles[] = $bubble;
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    /**
     * @return Bubble[]
     */
    public function getBubbles(): array
    {
        return $this->bubbles;
    }

}