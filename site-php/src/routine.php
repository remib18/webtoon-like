<?php

namespace WebtoonLike\Site;

use WebtoonLike\Site\core\Router;
use WebtoonLike\Site\routine\DatabaseLoader;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$clis = ["cgi", "cgi-fcgi", "cli", "cli-server"," fpm-fcgi"];
if (in_array(php_sapi_name(), $clis)) {
    DatabaseLoader::updateFromAzure();
} else {
   Router::redirect('/');
}