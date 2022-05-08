<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\LoginToken;
use WebtoonLike\Site\entities\NoIdOverwritingException;
use WebtoonLike\Site\utils\Database;

class LoginTokenController
{
    /**
     * @param string $token
     * @return LoginToken|null
     */
    public static function getByToken(string $token): ?LoginToken
    {
        return Database::getFirst('LoginToken', LoginToken::class, '*', ['token' => "token = '$token'"]);
    }

    /**
     * @param LoginToken $entity
     * @return bool
     * @throws NoIdOverwritingException
     */
    public static function create(LoginToken &$entity): bool
    {
        return Database::create('LoginToken', $entity);
    }

    /**
     * @param LoginToken $entity
     * @return bool
     */
    public static function remove(LoginToken &$entity): bool
    {
        return Database::remove('LoginToken', $entity);
    }
}