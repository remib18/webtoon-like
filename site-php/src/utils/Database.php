<?php

namespace WebtoonLike\Site\utils;

require_once __DIR__ . '/../settings.php';

class Database
{
    private static \mysqli $db;

    public static function getDB(): \mysqli {
        if (!isset(self::$db)) {
            self::$db = new \mysqli(...SETTINGS['database']);
        }
        return self::$db;
    }

}