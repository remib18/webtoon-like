<?php

namespace WebtoonLikeSitePhp\utils;

class DataBase
{
    private static \mysqli $db;

    public static function getDB(): \mysqli {
        if (!isset(DataBase::$db)) {
            // TODO: Replace root in production
            // Use of root user for development convenience
            DataBase::$db = new \mysqli('localhost', 'root', '', 'webtoonLike');
        }
        return DataBase::$db;
    }

}