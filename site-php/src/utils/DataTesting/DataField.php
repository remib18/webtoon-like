<?php

namespace WebtoonLike\Site\utils\DataTesting;

class DataField {

    private function __construct(
        private mixed $data,
        private bool $nullable,
        private ?int $minLength,
        private ?int $maxLength,
        private ?Regex $regex
    ) {}

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @return int|null
     */
    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    /**
     * @return int|null
     */
    public function getMinLength(): ?int
    {
        return $this->minLength;
    }

    /**
     * @param Regex|null $regex
     */
    public function setRegex(?Regex $regex): void
    {
        $this->regex = $regex;
    }

}