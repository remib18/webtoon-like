<?php

namespace WebtoonLike\Site\utils;

use mysqli;
use WebtoonLike\Site\Settings;

class Database
{
    private static mysqli $db;

    public static function getDB(): mysqli {
        if (!isset(self::$db)) {
            self::$db = new mysqli(...Settings::get('database'));
        }
        return self::$db;
    }

}