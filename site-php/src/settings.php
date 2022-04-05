<?php

namespace WebtoonLike\Site;

use JetBrains\PhpStorm\ArrayShape;

#[ArrayShape([
    'googleTranslateApi' => "string",
    'preTranslateTo' => "string[]",
    'webtoonsImagesBaseFolder' => "string",
    'database' => "array"
])]
function getSettings(): array{
    return [
        'googleTranslateApi' => '',
        'preTranslateTo' => [
            'fr',
            'en'
        ],
        'webtoonsImagesBaseFolder' => dirname(__DIR__) . '/assets/webtoons-imgs/',
        'database' => [
            'host' => 'localhost',
            'username' => 'root',       // TODO: Replace root in production
            'password' => null,
            'dbName' => 'webtoonLike',
            'port' => null,
            'socket' => null
        ]
    ];
}