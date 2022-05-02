<?php

namespace WebtoonLike\Site\utils\DataTesting;

use DateTime;

class DataField {

    /**
     * @param mixed $data
     * @param DataType $type
     * @param bool $nullable
     * @param int|DateTime|null $minLength
     * @param int|DateTime|null $maxLength
     * @param Regex|string|null $regex
     */
    public function __construct(
        private mixed $data,
        private DataType  $type,
        private bool $nullable = false, // null ou pas
        private null|int|DateTime $minLength = null,
        private null|int|DateTime $maxLength = null,
        private null|Regex|string $regex = null
    ) {

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
     * @return string|Regex|null
     */
    public function getRegex(): string|Regex|null
    {
        return $this->regex;
    }

}