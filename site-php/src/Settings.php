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
        'WEBTOONS_IMAGES_FOLDER' => baseDirectory . '/assets/webtoons-imgs/',
        'DATABASE' => [
            'hostname' => 'localhost',
            'username' => 'root',       // TODO: Replace root in production
            'password' => null,
            'database' => 'webtoonLike',
            'port' => null,
            'socket' => null
        ],
        'ROUTER' => [
            'GENERATED_PAGES_FOLDER' => baseDirectory . '/src/pages/php/',
            'PURE_PAGES_FOLDER' => baseDirectory . '/src/pages/html/',
            'HANDLERS_FOLDER' => baseDirectory . '/src/handlers/'
        ],
        'production' => false,
        'AZURE_API_KEY' => '...',
        'AZURE_API_LOCATION' => 'westeurope',
        'chapterFolder' => 'chapters/',
        'coverFolder' => ''
    ];

    public static function get(string $key): mixed {
        if (!isset(self::$settings[$key]))
            throw new \InvalidArgumentException('Key ' . $key . 'does not exist.');
        return self::$settings[$key];
    }

    #[ArrayShape([
        'GT_API_KEY_FILE' => "string",
        'preTranslateTo' => "string[]",
        'WEBTOONS_IMAGES_FOLDER' => "string",
        'DATABASE' => "array",
        'ROUTER' => "array",
        'production' => "bool",
        'AZURE_API_KEY' => "string",
        'AZURE_API_LOCATION' => 'string'
    ])]

    public static function getAll(): array {
        return self::$settings;
    }

}