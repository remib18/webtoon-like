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
     * @return bool|array
     */
    public static function register(String $username, String $email, String $password, string $password_confirmation): bool|array
    {
        $errors = [];

        if( !is_null(UserController::getByEmail($email)) ) {
            $errors['errorEmail'] = 'Email déjà utilisé';
        }

        if( !is_null(UserController::getByEmail($username)) ) {
            $errors['errorUsername'] = 'Username déjà utilisé';
        }

        if ( $password !== $password_confirmation ) {
            $errors['errorPassword'] = 'Mots de passes non-identique.';
        }

        if( empty($errors) ) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $dateTime = new \DateTime('now');
            $user = new User(null, $username, $email, $hashedPassword, $dateTime, false);

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
     * @return bool
     */
    public static function login(String $email, String $password): string|bool
    {
        $error = 'Le mot de passe ne correspond à l\'adresse email fournie.';

        $user = UserController::getByEmail($email);

        if(is_null($user)) {
            return $error;
        }

        $identicalPsd = password_verify($password, $user->getPassword() );

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