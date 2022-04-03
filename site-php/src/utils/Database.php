<?php

namespace WebtoonLikeSitePhp\utils;

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