<?php

use WebtoonLike\Site\Settings;

if( Settings::get('production') == false ) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

require 'src/index.php';