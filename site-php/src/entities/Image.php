<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use WebtoonLike\Site\controller\LanguageController;
use WebtoonLike\Site\exceptions\InvalidProtocolException;
use WebtoonLike\Site\Settings;
use WebtoonLike\Site\utils\DataTesting\DataField;
use WebtoonLike\Site\utils\DataTesting\DataType;

class Image implements EntityInterface
{

    private array $fieldsToSave = [];

    private ?int $id;
    private int $index;
    private string $path;
    private int $chapterId;
    private string $originalLanguage;
    private ?int $fontSize;
    private bool $needOCR;

    public function __construct(
        ?int $imageID,
        int $index,
        string $path,
        int $chapterID,
        string $originalLanguage,
        ?int $fontSize,
        bool $needOCR = true,
        bool $fromDB = true
    ) {
        $this->id = $imageID;
        $this->setIndex($index);
        $this->setPath($path);
        $this->setNeedOCR($needOCR);
        $this->setChapterId($chapterID);
        $this->setOriginalLanguage($originalLanguage);
        $this->setFontSize($fontSize);

        if ($fromDB) $this->AllFieldsSaved();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getIndex(): int {
        return $this->index;
    }

    /**
     * @param int $index
     */
    public function setIndex(int $index): void
    {
        $this->fieldsToSave['index'] = $index;
        $this->index = $index;
    }

    /**
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->fieldsToSave['path'] = $path;
        $this->path = $path;
    }

    /**
     * @return int
     */
    public function getChapterId(): int
    {
        return $this->chapterId;
    }

    /**
     * @param int $chapterId
     */
    public function setChapterId(int $chapterId): void
    {
        $this->fieldsToSave['chapterID'] = $chapterId;
        $this->chapterId = $chapterId;
    }

    /*
     * @return bool
     */
    public function doesNeedOCR(): bool
    {
        return $this->needOCR;
    }

    /**
     * @param bool $needOCR
     */
    public function setNeedOCR(bool $needOCR): void
    {
        $this->fieldsToSave['needOCR'] = $needOCR;
        $this->needOCR = $needOCR;
    }

    /**
     * @return string
     */
    public function getOriginalLanguageIdentifier(): string {
        return $this->originalLanguage;
    }

    /**
     * @return Language
     */
    public function getOriginalLanguage(): Language {
        return LanguageController::getById($this->originalLanguage);
    }

    /**
     * @return int|null
     */
    public function getFontSize(): ?int {
        return $this->fontSize;
    }

    /**
     * @param int|null $fontSize
     */
    public function setFontSize(?int $fontSize): void {
        $this->fieldsToSave['fontSize'] = $fontSize;
        $this->fontSize = $fontSize;
    }

    /**
     * @param string $originalLanguage
     */
    public function setOriginalLanguage(string $originalLanguage): void {
        $this->fieldsToSave['originalLanguage'] = $originalLanguage;
        $this->originalLanguage = $originalLanguage;
    }

    /**
     * Obtenir le code source de l'image
     *
     * @return mixed <PHP base type ressource>
     * @throws InvalidProtocolException
     */
    public function getRessource(): mixed
    {
        $dir = Settings::get('webtoonsImagesBaseFolder');
        //[$protocol, $ressource] = UriUtils::uriProtocol($this->path);
        $protocol = 'file';
        $ressource = $this->path;

        switch ($protocol) {
            case 'file':
                return fopen($dir . $ressource, 'r');
            case 'gs':
                // Todo: implement GoogleCloud Storage Option
            case 'http':
            case 'https':
                // TODO: load image from uri
            default:
                throw new InvalidProtocolException(
                    'The protocol ' . $protocol . ' can not bu used to reference an image.'
                );
        }
    }

    /**
     * @inheritDoc
     */
    #[Pure] #[ArrayShape([
        'imageID' => "int|null",
        'index' => "int",
        'path' => "string",
        'chapterID' => "int",
        'originalLanguage' => "string",
        'fontSize' => "int",
        'needOCR' => "bool"
    ])]
    public function __toArray(): array
    {
        return [
            'imageID' => $this->id,
            'index' => $this->index,
            'path' => $this->path,
            'chapterID' => $this->chapterId,
            'originalLanguage' => $this->originalLanguage,
            'fontSize' => $this->fontSize,
            'needOCR' => $this->needOCR
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getColumnsKeys(): array {
        return [
            'imageID',
            'index',
            'path',
            'chapterID',
            'originalLanguage',
            'fontSize',
            'needOCR'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getIdentifiers(): array
    {
        return ['imageID'];
    }

    /**
     * @inheritDoc
     */
    public function getTypes(): array
    {
        return [
            'imageID' =>  new DataField($this->id, DataType::int, true),
            'index' =>  new DataField($this->index, DataType::int),
            'path' => new DataField($this->path, DataType::string),
            'chapterID' => new DataField($this->chapterId, DataType::int),
            'originalLanguage' => new DataField($this->originalLanguage, DataType::string, false, 2, 256, null),
            'fontSize' => new DataField($this->fontSize, DataType::int, true),
            'needOCR' => new DataField($this->needOCR, DataType::bool)
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