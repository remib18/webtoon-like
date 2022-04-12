<?php

namespace WebtoonLike\Site\utils;

use mysqli;
use WebtoonLike\Site\entities\EntityInterface;
use WebtoonLike\Site\Settings;

class Database
{
    private static mysqli $db;

    /**
     * Obtenir l'instance de la base de données
     *
     * @return mysqli
     */
    public static function getDB(): mysqli {
        if (!isset(self::$db)) {
            self::$db = new mysqli(...Settings::get('database'));
        }
        return self::$db;
    }

    /**
     * Transforme une réponse mysqli en tableau d'objets
     *
     * @param array $response Réponse mysqli avec un fetchAll assoc
     * @param string $class Classe représentant les objects
     *
     * @return array<EntityInterface>
     */
    public static function responseToObjects(array $response, string $class): array {
        $res = [];
        foreach ($response as $item) {
            $res[] = new $class(...$item);
        }
        return $res;
    }

}