<?php

namespace WebtoonLike\Site\entities;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use WebtoonLike\Site\exceptions\InvalidProtocolException;
use WebtoonLike\Site\Settings;
use WebtoonLike\Site\utils\UriUtils;

class Image implements EntityInterface
{

    public function __construct(
        private int $id,
        private int $imgPosition,
        private string $path,
        private int $chapterId
    ) {}

    /**
     * @return int
     */
    public function getId(): int {
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
     * @return int
     */
    public function getImgPosition(): int {
        return $this->imgPosition;
    }

    /**
     * @param int $imgPosition
     */
    public function setImgPosition(int $imgPosition): void
    {
        $this->imgPosition = $imgPosition;
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
            'imgPosition' => $this->imgPosition,
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