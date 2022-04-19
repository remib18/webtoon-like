<?php

namespace WebtoonLike\Site;

use JetBrains\PhpStorm\ArrayShape;

define("WebtoonLike\Site\baseDirectory", dirname(__DIR__));

class Settings {

    private static array $settings = [
        'GT_API_KEY_FILE' => baseDirectory . '/google-key.json',
        'preTranslateTo' => [
            'fr',
            'en'
        ],
        'webtoonsImagesBaseFolder' => baseDirectory . '/assets/webtoons-imgs/',
        'DATABASE' => [
            'hostname' => 'localhost',
            'username' => 'root',       // TODO: Replace root in production
            'password' => null,
            'database' => 'webtoonLike',
            'port' => null,
            'socket' => null
        ],
        'production' => false,
        'AZURE_API_KEY' => ''
    ];

    public static function get(string $key): mixed {
        if (!isset(self::$settings[$key]))
            throw new \InvalidArgumentException('Key ' . $key . 'does not exist.');
        return self::$settings[$key];
    }

    #[ArrayShape([
        'GT_API_KEY_FILE' => "string",
        'preTranslateTo' => "string[]",
        'webtoonsImagesBaseFolder' => "string",
        'DATABASE' => "array",
        'AZURE_API_KEY' => "string"
    ])]
    public static function getAll(): array {
        return self::$settings;
    }

}