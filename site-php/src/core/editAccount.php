<?php

namespace WebtoonLike\Site\core;

use WebtoonLike\Site\controller\UserController;

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

        if(is_null($user)) { return 'un problème est survenu'; }

        if(is_null($potentialUser) && $email !== $user->getEmail()) {
            $user->setEmail($email);

            if(!UserController::edit($user)) {
                return 'Votre email n\'est pas valide';
            }

            return true;
        }

        return 'Cette adresse email existe existe deja';
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

        if(is_null($user)) { return 'un problème est survenu'; }

        if(is_null($potentialUser) && $username !== $user->getUsername()) {
            $user->setUsername($username);

            if(!UserController::edit($user)) {
                return 'Votre pseudonyme n\'est pas valide';
            }

            return true;
        }

        return 'Ce pseudo n\'est pas disponible';
    }

}