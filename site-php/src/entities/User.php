<?php

namespace WebtoonLike\Site\entities;

use Google\Type\Date;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class User implements EntityInterface
{
    public function __construct(
        private int $id,
        private string $username,
        private string $email,
        private \DateTime $registeredAt
    ){}

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return \DateTime
     */
    public function getRegisteredAt(): \DateTime
    {
        return $this->registeredAt;
    }

    /**
     * @param \DateTime $registeredAt
     */
    public function setRegisteredAt(\DateTime $registeredAt): void
    {
        $this->registeredAt = $registeredAt;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    #[ArrayShape(['id' => "int", 'username' => "string", 'email' => "string", 'registeredAt' => "\DateTime"])]
    public function __toArray(): array {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'registeredAt' => $this->registeredAt
        ];
    }
}