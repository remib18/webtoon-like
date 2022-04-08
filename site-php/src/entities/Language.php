<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;

class Language implements EntityInterface
{
    private string $id;
    private string $name;

    function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    #[ArrayShape(['id' => "string", 'name' => "string"])]
    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
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