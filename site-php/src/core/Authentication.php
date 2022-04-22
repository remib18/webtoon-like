<?php

namespace WebtoonLike\Site\core;


class Authentication {

    /**
     * Initialise la session.
     *
     * @return void
     */
    public static function innitSession(): void {
        session_start();
        if(!isset($_SESSION['accessLevel'])) {
            $_SESSION['accessLevel'] = AccessLevel::Unlogged;
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
    public static function hasAccess(AccessLevel $requiredLevel): bool {
        $sessionLevel = Authentication::getUserAccessLevel();

        if($requiredLevel === AccessLevel::Everyone || $sessionLevel === $requiredLevel) {
            return true;
        }

        return False;
    }

}