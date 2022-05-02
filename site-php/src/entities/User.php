<?php

namespace WebtoonLike\Site\entities;

use DateTime;
use Google\Type\Date;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class User implements EntityInterface
{

    private array $fieldsToSave = [];

    private ?int $id;
    private string $username;
    private string $email;
    private string $password;
    private DateTime $registeredAt;

    public function __construct(
        ?int $userID,
        string $username,
        string $email,
        string $password,
        DateTime|string $registeredAt,
        bool $fromDB = true
    ){
        $this->id = $userID;
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
        if(is_string($registeredAt)) {
            $registeredAt = new DateTime($registeredAt);
        }
        $this->registeredAt = $registeredAt;

        if ($fromDB) $this->AllFieldsSaved();
        else $this->fieldsToSave['registeredAt'] = $registeredAt->format('Y-m-d H:i:s');
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
        $this->fieldsToSave['email'] = $email;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->fieldsToSave['password'] = $password;
        $this->password = $password;
    }

    /**
     * @return DateTime
     */
    public function getRegisteredAt(): DateTime
    {
        return $this->registeredAt;
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
        $this->fieldsToSave['username'] = $username;
        $this->username = $username;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([
        'userID' => "int",
        'username' => "string",
        'email' => "string",
        'password' => "password",
        'registeredAt' => "\DateTime"
    ])]
    public function __toArray(): array {
        return [
            'userID' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'registeredAt' => $this->registeredAt
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getColumnsKeys(): array {
        return [
            'userID',
            'username',
            'email',
            'password',
            'registeredAt'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getIdentifiers(): array
    {
        return ['userID'];
    }

    /**
     * @inheritDoc
     */
    public function getTypes(): array
    {
        return [
            'userID' => "int",
            'username' => "string",
            'email' => "string",
            'password' => "string",
            'registeredAt' => "\DateTime"
        ];
    }

    /**
     * @inheritDoc
     */
    public function getFieldsToSave(): array
    {
        return $this->fieldsToSave;
    }

    /**
     * @inheritDoc
     */
    public function AllFieldsSaved(): void
    {
        $this->fieldsToSave = [];
    }

    /**
     * @inheritDoc
     */
    public function setId(int $id): void {
        if (!is_null($this->id)) throw new NoIdOverwritingException();
        $this->id = $id;
    }
}