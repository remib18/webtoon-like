<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use WebtoonLike\Site\exceptions\InvalidProtocolException;
use WebtoonLike\Site\Settings;
use WebtoonLike\Site\utils\UriUtils;

class Image implements EntityInterface
{
    private ?int $id;
    private int $chapterId;

    public function __construct(
        ?int $imageID,
        private int    $index,
        private string $path,
        int $chapterID,
        private bool   $needOCR = true
    ) {
        $this->id = $imageID;
        $this->chapterId = $chapterID;
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
        $this->needOCR = $needOCR;
    }

    /**
     * @return array<string, mixed>
     */
    #[Pure]
    #[ArrayShape([
        'imageId' => "int",
        'imgPosition' => "int",
        'path' => "string",
        'chapterId' => "int"
    ])]
    public function __toArray(): array
    {
        return [
            'imageId' => $this->id,
            'imgPosition' => $this->index,
            'path' => $this->path,
            'chapterId' => $this->chapterId
        ];
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
}