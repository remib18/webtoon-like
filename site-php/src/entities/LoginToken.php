<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;

class LoginToken implements EntityInterface
{

    private array $fieldsToSave = [];

    private string $token;
    private int $lifeSpan;
    private int $userID;

    public function __construct(
        string $token,
        int $lifeSpan,
        int $userID,
        bool $fromDB = true
    ) {
        $this->setToken($token);
        $this->setLifeSpan($lifeSpan);
        $this->setUserID($userID);

        if ($fromDB) $this->AllFieldsSaved();
    }

    /**
     * @param int $lifeSpan
     */
    public function setLifeSpan(int $lifeSpan): void
    {
        $this->fieldsToSave['lifeSpan'] = $lifeSpan;
        $this->lifeSpan = $lifeSpan;
    }

    /**
     * @param string $token
     */
    private function setToken(string $token): void
    {
        $this->fieldsToSave['token'] = $token;
        $this->token = $token;
    }

    /**
     * @param int $userID
     */
    public function setUserID(int $userID): void
    {
        $this->fieldsToSave['userID'] = $userID;
        $this->userID = $userID;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return int
     */
    public function getLifeSpan(): int
    {
        return $this->lifeSpan;
    }

    /**
     * @return int
     */
    public function getUserID(): int
    {
        return $this->userID;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([
        'token' => "mixed",
        'lifeSpan' => "mixed",
        'userID' => "mixed"]
    )]
    public function __toArray(): array
    {
        return [
            'token' => $this->token,
            'lifeSpan' => $this->lifeSpan,
            'userID' => $this->userID
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getColumnsKeys(): array
    {
        return [
            'token',
            'lifeSpan',
            'userID'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getIdentifiers(): array
    {
        return ['token'];
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([
        'token' => "string",
        'lifeSpan' => "string",
        'userID' => "string"])]
    public static function getTypes(): array
    {
        return [
            'token' => "string",
            'lifeSpan' => "int",
            'userID' => "int"
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
    public function setId(int $id): void {}

}