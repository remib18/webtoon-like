<?php

namespace WebtoonLikeSitePhp\utils;

class Database
{
    private static \mysqli $db;
    private static array $settings = SETTINGS['database'];

    public static function getDB(): \mysqli {
        if (!isset(self::$db)) {
            self::$db = new \mysqli(...self::$settings);
        }
        return self::$db;
    }

}