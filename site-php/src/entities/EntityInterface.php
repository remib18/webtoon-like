<?php

namespace WebtoonLike\Site\entities;

interface EntityInterface
{

    public function __toArray(): array;

    public static function getColumnsKeys(): array;

}