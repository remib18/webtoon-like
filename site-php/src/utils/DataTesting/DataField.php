<?php

namespace WebtoonLike\Site\utils\DataTesting;

class DataField {

    private function __construct(
        private mixed $data,
        private bool $nullable,
        private ?int $minLength,
        private ?int $maxLength,
        private ?string $regex
    ) {}
    
}