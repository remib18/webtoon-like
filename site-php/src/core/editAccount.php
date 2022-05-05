<?php

namespace WebtoonLike\Site\core;

use WebtoonLike\Site\controller\UserController;
use WebtoonLike\Site\utils\Database;

class editAccount
{
    /**
     * Edition des emails.
     *
     * @param int $userId
     * @param string $email
     * @return bool|string
     */
    public static function editEmail(int $userId, string $email): bool|string {

        $user = UserController::getById($userId);
        $potentialUser = UserController::getByEmail($email);

        if(is_null($user)) return 'un problème est survenu';

        if(is_null($potentialUser) && $email !== $user->getEmail()) {
            $user->setEmail($email);

            if(!UserController::edit($user)) return 'Votre email n\'est pas valide';

            return true;
        }

        return 'Cette adresse email n\'est pas disponible';
    }

    /**
     * Edition de pseudonyme
     *
     * @param int $userId
     * @param string $username
     * @return bool|string
     */
    public static function editUsername(int $userId, string $username): bool|string {

        $user = UserController::getById($userId);
        $potentialUser = UserController::getByUsername($username);

        if(is_null($user)) return 'un problème est survenu';

        if(is_null($potentialUser) && $username !== $user->getUsername()) {
            $user->setUsername($username);

            if(!UserController::edit($user)) return 'Votre pseudonyme n\'est pas valide';

            return true;
        }

        return 'Ce pseudo n\'est pas disponible';
    }

    public static function editPassword(
        int $userId,
        string $password,
        $new_password,
        $confirmationNewPassword
    ): bool|string {
        if($new_password !== $confirmationNewPassword) return 'Mots de passe non-identique';

        $user = UserController::getById($userId);
        if(is_null($user)) return 'un problème est survenu';

        $identicalPsd = password_verify($password, str_replace("'", "", $user->getPassword()));

        if($identicalPsd) {
            $user->setPassword(Database::normalizeValue(password_hash($new_password, PASSWORD_DEFAULT)));

            if(!UserController::edit($user)) return 'Nous n\'avons pas pu changer votre mot de passe';

            return true;
        }

        return 'Votre mot de passe actuel n\'est pas valide';
    }
}