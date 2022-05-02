<?php

namespace WebtoonLike\Site\core;


use DateTime;
use JetBrains\PhpStorm\NoReturn;
use WebtoonLike\Site\controller\LoginTokenController;
use WebtoonLike\Site\controller\UserController;
use WebtoonLike\Site\entities\LoginToken;
use WebtoonLike\Site\entities\NoIdOverwritingException;
use WebtoonLike\Site\entities\User;
use WebtoonLike\Site\utils\Database;
use WebtoonLike\Site\utils\PageUtils;

class Authentication {

    /**
     * Initialise la session.
     *
     * @return void
     */
    private static function innitSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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
     * @param AccessLevel|null $requiredLevel
     * @param bool $strict
     * @return bool
     */
    public static function hasAccess(?AccessLevel $requiredLevel = null, bool $strict = false): bool {

        self::innitSession();
        self::tryLoggingFromCookie();

        if(is_null($requiredLevel)) {
            $requiredLevel = PageUtils::getPageAccess();
        }

        if($strict) {
            return Authentication::getUserAccessLevel()->value === $requiredLevel->value;
        }

        return Authentication::getUserAccessLevel()->value >= $requiredLevel->value;
    }

    /**
     * Register user to the database.
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $password_confirmation
     * @return bool|array
     * @throws NoIdOverwritingException
     */
    public static function register(string $username, string $email, string $password, string $password_confirmation): bool|array
    {
        $errors = [];

        if( !is_null(UserController::getByEmail($email)) ) {
            $errors['errorEmail'] = 'Email déjà utilisé';
        }

        if( !is_null(UserController::getByUsername($username)) ) {
            $errors['errorUsername'] = 'Username déjà utilisé';
        }

        if ( $password !== $password_confirmation ) {
            $errors['errorPassword'] = 'Mots de passes non-identique';
        }

        if( empty($errors) ) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $dateTime = new DateTime('now');

            $user = new User(
                null,
                $username,
                $email,
                Database::normalizeValue($hashedPassword), // encodage pour la requête BDD.
                $dateTime,
                false
            );

            UserController::create($user);
            return self::login($email, $password);
        }

        return $errors;
    }

    /**
     * Log on website.
     *
     * @param string $email
     * @param string $password
     * @return string|bool
     */
    public static function login(string $email, string $password, bool $rememberMe = false): string|bool
    {
        $error = 'Le mot de passe ne correspond à l\'adresse email fournie';

        $user = UserController::getByEmail($email);

        if(is_null($user)) {
            return $error;
        }

        $identicalPsd = password_verify($password, str_replace("'", "", $user->getPassword()));

        if( $identicalPsd ) {

            $_SESSION['accessLevel'] = AccessLevel::authenticated;
            $_SESSION['id'] = $user->getId();

            if( $rememberMe ) {
                $lifeSpan = time() + 86400 * 14;
                $token = strtoupper(md5(openssl_random_pseudo_bytes(64) . time() . rand(0, 1000)));

                $res = LoginTokenController::create(new LoginToken($token, $lifeSpan, $user->getId(), false));
                if($res !== false ) {
                    setcookie('rememberMe', $token, time() + 86400);
                }
            }

            return true;
        }


        return $error;
    }

    /**
     * Logout du site web.
     *
     * @return void
     */
    #[NoReturn] public static function logout(): void {

        if(isset($_COOKIE['rememberMe'])) {
            $token = mysqli_real_escape_string(Database::getDB(), $_COOKIE['rememberMe']);
            $tokenEntity =  LoginTokenController::getByToken($token);
            self::deleteRememberMeCookie($tokenEntity);
        }

        session_destroy();
        Router::redirect('/');
    }

    /**
     * Gère la suppression des cookies rememberMe.
     *
     * @param LoginToken|null $tokenEntity
     * @return void
     */
    private static function deleteRememberMeCookie(?LoginToken $tokenEntity): void {
        // On supprime le cookie en le mettant à un temps antérieur.
        setcookie('rememberMe', 'outdated', time() - 2022);
        if(is_null($tokenEntity)) return;
        LoginTokenController::remove($tokenEntity);
    }

    /**
     * Vérifie que les cookies rememberMe sont valides les supprimes si invalide.
     *
     * @return void
     */
    private static function tryLoggingFromCookie(): void
    {
        if(!isset($_COOKIE['rememberMe'])
            || empty($_COOKIE['rememberMe'])
            || $_SESSION['accessLevel'] !== AccessLevel::everyone
        ) return;

        // Risque d'injection SQL.
        $token = mysqli_real_escape_string(Database::getDB(), $_COOKIE['rememberMe']);
        $tokenEntity =  LoginTokenController::getByToken($token);

        // Pas de token en BDD
        if(is_null($tokenEntity)) return;

        if($tokenEntity->getLifeSpan() < time()) {
            self::deleteRememberMeCookie($tokenEntity);
            return;
        }

        $_SESSION['accessLevel'] = AccessLevel::authenticated;
        $_SESSION['id'] = $tokenEntity->getUserID();
    }

}
