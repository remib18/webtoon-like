<?php

namespace WebtoonLike\Site\core;


use WebtoonLike\Site\utils\PageUtils;

class Authentication {

    /**
     * Initialise la session.
     *
     * @return void
     */
    public static function innitSession(): void {
        session_start();
        if(!isset($_SESSION['accessLevel'])) {
            $_SESSION['accessLevel'] = AccessLevel::everyone;
        }
    }

    /**
     * Retourne l'accessLevel en session.
     *
     * @return AccessLevel
     */
    public static function getUserAccessLevel(): AccessLevel{
        return $_SESSION['accessLevel'];
    }

    /**
     * Compare l'accessLevel de la session avec le niveau exigé.
     *
     * @return bool
     */
    public static function hasAccess(?AccessLevel $requiredLevel = null, bool $strict = false): bool {

        if(is_null($requiredLevel)) {
            $requiredLevel = PageUtils::getPageAccess();
        }

        if($strict) {
            return Authentication::getUserAccessLevel()->value === $requiredLevel->value;
        }

        return Authentication::getUserAccessLevel()->value >= $requiredLevel->value;
    }

    public static function register(String $username, String $email, String $password, string $password_confirmation): bool
    {
        return false;
    }

    public static function login(String $email, String $password): bool
    {
        return false;
    }

}