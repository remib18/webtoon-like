<?php

namespace WebtoonLike\Site\core;


use JetBrains\PhpStorm\NoReturn;
use WebtoonLike\Site\controller\UserController;
use WebtoonLike\Site\entities\User;
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

    /**
     * Register user to the database.
     *
     * @return bool
     */
    public static function register(String $username, String $email, String $password, string $password_confirmation): bool
    {
        $errors = [];

        if( !is_null(UserController::getByEmail($email)) ) {
            $errors[] = 'Email déjà utilisé';
        }

        if( !is_null(UserController::getByEmail($username)) ) {
            $errors[] = 'Username déjà utilisé';
        }

        if ( $password !== $password_confirmation ) {
            $errors[] = 'Mots de passes non-identique.';
        }

        if( empty($errors) ) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user = new User($username, $email, $hashedPassword);

            $_SESSION['accessLevel'] = AccessLevel::authenticated;
            $_SESSION['id'] = $user->getId();

            return UserController::create($user);
        }

        return false;
    }

    /**
     * Log on website.
     *
     * @param String $email
     * @param String $password
     * @return bool
     */
    public static function login(String $email, String $password): bool
    {

        $user = UserController::getByEmail($email);
        $identicalPsd = password_verify($password, $user->getPassword() );

        if( $user->getEmail() === $email && $identicalPsd === true ) {

            $_SESSION['accessLevel'] = AccessLevel::authenticated;
            $_SESSION['id'] = $user->getId();

            return true;
        }

        return false;
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