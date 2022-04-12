<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;

class Language implements EntityInterface
{

    public function __construct(
        private string $identifier,
        private string $name
    ){}

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    #[ArrayShape(['identifier' => "string", 'name' => "string"])]
    public function __toArray(): array
    {
        return [
            'identifier' => $this->identifier,
            'name' => $this->name
        ];
    }
}