<?php

namespace WebtoonLike\Site;

use JetBrains\PhpStorm\ArrayShape;

// Noter que tous les paths sont relatifs au dossier site-php

#[ArrayShape([
    'GT_API_KEY_FILE' => "string",
    'preTranslateTo' => "string[]",
    'webtoonsImagesBaseFolder' => "string",
    'database' => "array"
])]
function getSettings(): array{
    return [
        'GT_API_KEY_FILE' => '/google-key.json',
        'preTranslateTo' => [
            'fr',
            'en'
        ],
        'webtoonsImagesBaseFolder' => '/assets/webtoons-imgs/',
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