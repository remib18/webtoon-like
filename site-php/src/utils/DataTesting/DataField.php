<?php

namespace WebtoonLike\Site\utils\DataTesting;

use DateTime;

class DataField
{

    /**
     * @param mixed $data
     * @param DataType $type
     * @param bool $nullable
     * @param int|DateTime|null $minLength
     * @param int|DateTime|null $maxLength
     * @param ?string $regex
     */
    public function __construct(
        private mixed             $data,
        private DataType          $type,
        private bool              $nullable = false, // null ou pas
        private null|int|DateTime $minLength = null,
        private null|int|DateTime $maxLength = null,
        private ?string           $regex = null
    )
    {

    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @return DataType
     */
    public function getType(): DataType
    {
        return $this->type;
    }

    public function getNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * @return DateTime|int|null
     */
    public function getMaxLength(): DateTime|int|null
    {
        return $this->maxLength;
    }

    /**
     * @return DateTime|int|null
     */
    public function getMinLength(): DateTime|int|null
    {
        return $this->minLength;
    }

    /**
     * @return string|null
     */
    public function getRegex(): ?string
    {
        return $this->regex;
    }

}