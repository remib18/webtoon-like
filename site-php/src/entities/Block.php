<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use WebtoonLike\Site\features\Translation\Result\Bloc;
use WebtoonLike\Site\utils\DataTesting\DataField;
use WebtoonLike\Site\utils\DataTesting\DataType;
use WebtoonLike\Site\utils\DataTesting\DataVerification;

class Block implements EntityInterface
{

    private array $fieldsToSave = [];
    private string $originalContent;
    private int $startX;
    private int $startY;
    private int $endX;
    private int $endY;

    private ?int $id;
    private int $imageId;

    /** @var string[] $translations La liste des traductions chargées */
    private array $translations = [];

    public function __construct(
        ?int $blockID,
        string $originalContent,
        int $startX,
        int $startY,
        int $endX,
        int $endY,
        int $imageID,
        bool $fromDB = true
    ) {
        $this->id = $blockID;
        $this->setOriginalContent($originalContent);
        $this->setStartX($startX);
        $this->setStartY($startY);
        $this->setEndX($endX);
        $this->setEndY($endY);
        $this->setImageId($imageID);

        if ($fromDB) $this->AllFieldsSaved();
    }

    public static function merge(Block $current, Block $next): Block {
        if ($next->getStartX() < $current->getStartX()) {
            $current->setStartX($next->getStartX());
        }
        if ($next->getStartY() < $current->getStartY()) {
            $current->setStartY($next->getStartY());
        }

        if ($next->getEndX() > $current->getEndX()) {
            $current->setEndX($next->getEndX());
        }
        if ($next->getEndY() > $current->getEndY()) {
            $current->setEndY($next->getEndY());
        }

        $current->setOriginalContent(
            $current->getOriginalContent() . ' ' . $next->getOriginalContent()
        );

        return $current;
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
    public function getImageId(): int
    {
        return $this->imageId;
    }

    /**
     * @param int $imageId
     */
    public function setImageId(int $imageId): void
    {
        $this->fieldsToSave['imageID'] = $imageId;
        $this->imageId = $imageId;
    }

    /**
     * @return int
     */
    public function getEndX(): int
    {
        return $this->endX;
    }

    /**
     * @param int $endX
     */
    public function setEndX(int $endX): void
    {
        $this->fieldsToSave['endX'] = $endX;
        $this->endX = $endX;
    }

    /**
     * @return int
     */
    public function getEndY(): int
    {
        return $this->endY;
    }

    /**
     * @param int $endY
     */
    public function setEndY(int $endY): void
    {
        $this->fieldsToSave['endY'] = $endY;
        $this->endY = $endY;
    }

    /**
     * @return string
     */
    public function getOriginalContent(): string
    {
        return $this->originalContent;
    }

    /**
     * @param string $originalContent
     */
    public function setOriginalContent(string $originalContent): void
    {
        $this->fieldsToSave['originalContent'] = $originalContent;
        $this->originalContent = $originalContent;
    }

    /**
     * @return int
     */
    public function getStartX(): int
    {
        return $this->startX;
    }

    /**
     * @param int $startX
     */
    public function setStartX(int $startX): void
    {
        $this->fieldsToSave['startX'] = $startX;
        $this->startX = $startX;
    }

    /**
     * @return int
     */
    public function getStartY(): int
    {
        return $this->startY;
    }

    /**
     * @param int $startY
     */
    public function setStartY(int $startY): void
    {
        $this->fieldsToSave['startY'] = $startY;
        $this->startY = $startY;
    }

    public function registerTranslation(string $languageId, string $translation): void {
        $this->translations[$languageId] = $translation;
    }

    public function getTranslation(string $languageId): string {
        return $this->translations[$languageId];
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([
        'blockID' => "int",
        'startX' => "int",
        'startY' => "int",
        'endX' => "int",
        'endY' => "int",
        'originalContent' => "string",
        'imageID' => "int"
    ])]
    public function __toArray(): array {
        return [
            'blockID' => $this->id,
            'startX' => $this->startX,
            'startY' => $this->startY,
            'endX' => $this->endX,
            'endY' => $this->endY,
            'originalContent' => $this->originalContent,
            'imageID' => $this->imageId
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getColumnsKeys(): array {
        return [
            'blockID',
            'originalContent',
            'startX',
            'startY',
            'endX',
            'endY',
            'imageID'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getIdentifiers(): array
    {
        return ['blockID'];
    }

    /**
     * @inheritDoc
     */
    public function getTypes(): array
    {
        return [
            'blockID' => new DataField($this->id, DataType::int),
            'startX' => new DataField($this->startX, DataType::int),
            'startY' => new DataField($this->startY, DataType::int),
            'endX' => new DataField($this->endX, DataType::int),
            'endY' => new DataField($this->endY, DataType::int),
            'originalContent' => new DataField($this->originalContent, DataType::string),
            'imageID' =>  new DataField($this->imageId, DataType::int)
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