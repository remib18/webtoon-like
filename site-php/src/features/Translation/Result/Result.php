<?php

namespace WebtoonLike\Site\features\Translation\Result;

class Result
{

    /** @var array<Bubble> $bubbles */
    private array $bubbles = [];

    /**
     * @param string|null $imagePath Le chemin de l'image à partir du dossier de webtoons. Null si une image manque
     */
    public function __construct(
        private ?string $imagePath
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