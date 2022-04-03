<?php

namespace WebtoonLike\Site\utils;

use function WebtoonLike\Site\getSettings;

class Database
{
    private static \mysqli $db;

    public static function getDB(): \mysqli {
        if (!isset(self::$db)) {
            self::$db = new \mysqli(...getSettings()['database']);
        }
        return self::$db;
    }

}