<?php

namespace WebtoonLike\Site\core;

use WebtoonLike\Site\controller\UserController;

class deleteAccount
{
    /**
     * Gestion de la suppression de compte.
     *
     * @param int $userId
     * @param string $password
     * @return bool|string
     */
    public static function deleteAccount(int $userId, string $password): bool|string {

        $user = UserController::getById($userId);

        if(is_null($user)) { return 'un problème est survenu'; }

        $identicalPsd = password_verify($password, str_replace("'", "", $user->getPassword()));

        if( $identicalPsd ) {
            $user->setEmail('delete@user.removed');
            $user->setUsername('deletedUser');
            $user->setDeleted(true);
            $edit = UserController::edit($user);

            if(!$edit) { return 'Nous n\'avons pas réussi à supprimer votre compte';}
            return true;
        }
        return 'Votre mot de passe est incorrect';
    }
}