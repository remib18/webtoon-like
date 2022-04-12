<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Report implements EntityInterface
{

    private ?int $id;
    private int $userId;

    public function __construct(
        ?int $reportID,
        private int $type,
        int $userID
    ) {
        $this->id = $reportID;
        $this->userId = $userID;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    #[ArrayShape(['id' => "int", 'type' => "int", 'userId' => "int"])]
    public function __toArray(): array {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'userId' => $this->userId
        ];
    }

    public static function getColumnsKeys(): array {
        return [
            'reportID',
            'type',
            'userID'
        ];
    }

}