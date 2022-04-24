<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\NoIdOverwritingException;
use WebtoonLike\Site\entities\user;
use WebtoonLike\Site\utils\Database;

class UserController
{
    /**
     * Obtenir la liste des users
     *
     * @param string|array $col
     * @param array $where
     *
     * @return User[]
     */
    public static function getAll(string|array $col = '*', array $where = []): array
    {
        return Database::getAll('user', User::class, $col, $where);
    }

    /* Obtention de l'user avec l'identifiant correspondant.
    *
    * @param int $id Identifiant recherché
    * @return User|null
    */
    public static function getById(int $id): ?User
    {
        return Database::getFirst('User', user::class, '*', ['userID' => "userID = $id"]);
    }

    /* Obtention de l'user avec l'email correspondant.
    *
    * @param string $email email recherché
    * @return User|null
    */
    public static function getByEmail(string $email): ?User
    {
        return Database::getFirst('User', user::class, '*', ['email' => "email = '$email'"]);
    }

    /* Obtention de l'user avec l'username correspondant.
    *
    * @param string $username username  recherché
    * @return User|null
    */
    public static function getByUsername(string $username): ?User
    {
        return Database::getFirst('User', user::class, '*', ['username' => "username = '$username'"]);
    }

    /**
     * La ressource fournit existe-t-elle ?
     *
     * @param int $id Ressource correspondante
     * @return bool
     */
    public static function exists(int $id): bool {
        $q = "SELECT userID FROM User WHERE userID = $id";
        $res = Database::getDB()->query($q)->fetch_assoc();
        return sizeof($res ?? []) > 0;
    }

    /**
     * Enregistre un user et retourne son identifiant ou <code>false</code> en cas d'erreur.
     *
     * @param User $entity
     *
     * @return bool Faux en cas d'erreur
     *
     * @throws NoIdOverwritingException
     */
    public static function create(User &$entity): bool
    {
        return Database::create('User', $entity);
    }

    /**
     * Modifie l'user
     *
     * @param User $entity L'user modifiée
     * @return bool Retourne vrai si la modification a été effectuée avec succès.
     */
    public static function edit(User &$entity): bool
    {
        return Database::edit('User', $entity);
    }

    /**
     * Supprime l'user correspondant à l'identifiant fournit.
     *
     * @param User $entity L'identifiant de l'user à supprimer.
     * @return bool Retourne vrai si la suppression a été effectuée avec succès.
     */
    public static function remove(User $entity): bool
    {
        return Database::remove('User', $entity);
    }
}