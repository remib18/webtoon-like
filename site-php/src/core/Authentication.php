<?php

namespace WebtoonLike\Site\core;


use DateTime;
use JetBrains\PhpStorm\NoReturn;
use WebtoonLike\Site\controller\UserController;
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
        if(!isset($_SESSION)){
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
     * @param String $username
     * @param String $email
     * @param String $password
     * @param string $password_confirmation
     * @return bool|array
     * @throws NoIdOverwritingException
     */
    public static function register(String $username, String $email, String $password, string $password_confirmation): bool|array
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

            $_SESSION['accessLevel'] = AccessLevel::authenticated;
            $_SESSION['id'] = $user->getId();

            return UserController::create($user);
        }

        return $errors;
    }

    /**
     * Log on website.
     *
     * @param String $email
     * @param String $password
     * @return string|bool
     */
    public static function login(string $email, string $password): string|bool
    {
        $error = 'Le mot de passe ne correspond à l\'adresse email fournie';

        $user = UserController::getByEmail($email);

        if(is_null($user)) {
            return $error;
        }

        $identicalPsd = password_verify($password, str_replace("'", "", $user->getPassword()));

        if( $identicalPsd === true ) {

            $_SESSION['accessLevel'] = AccessLevel::authenticated;
            $_SESSION['id'] = $user->getId();

            return true;
        }

        return $error;
    }

    /**
     * Logout from website.
     *
     * @return void
     */
    #[NoReturn] public static function logout(): void {
        session_destroy();
        Router::redirect('/home');
    }

}