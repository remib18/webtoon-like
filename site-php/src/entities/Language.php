<?php

namespace WebtoonLike\Site\entities;

class Language implements EntityInterface
{

    private string $name;

    public function __toArray(): array
    {
        // TODO: Implement __toArray() method.
        return [];
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
}