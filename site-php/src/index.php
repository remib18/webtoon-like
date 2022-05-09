<?php

namespace WebtoonLike\Site;

require_once __DIR__ . '/../vendor/autoload.php';

use WebtoonLike\Site\core\Router;
use WebtoonLike\Site\core\RouterMode;

if (Settings::get('production') === false) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

Router::route(RouterMode::GENERATED_HTML, null);
