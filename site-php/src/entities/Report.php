<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use WebtoonLike\Site\utils\DataTesting\DataField;
use WebtoonLike\Site\utils\DataTesting\DataType;

class Report implements EntityInterface
{

    private array $fieldsToSave = [];

    private ?int $id;
    private int $type;
    private int $userId;

    public function __construct(
        ?int $reportID,
        int $type,
        int $userID,
        bool $fromDB = true
    ) {
        $this->id = $reportID;
        $this->setType($type);
        $this->setUserId($userID);

        if ($fromDB) $this->AllFieldsSaved();
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
        $this->fieldsToSave['$type'] = $type;
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
        $this->fieldsToSave['userID'] = $userId;
        $this->userId = $userId;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([
        'reportID' => "int",
        'type' => "int",
        'userID' => "int"
    ])]
    public function __toArray(): array {
        return [
            'reportID' => $this->id,
            'type' => $this->type,
            'userID' => $this->userId
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getColumnsKeys(): array {
        return [
            'reportID',
            'type',
            'userID'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getIdentifiers(): array
    {
        return ['reportID'];
    }

    /**
     * @inheritDoc
     */
    public function getTypes(): array
    {
        return [
            'reportID' => new DataField($this->id, DataType::int, true),
            'type' => new DataField($this->type, DataType::int),
            'userID' => new DataField($this->userId, DataType::int)
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