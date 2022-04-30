<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\LoginToken;
use WebtoonLike\Site\utils\Database;

class LoginTokenController
{
    public static function getByToken(string $token): ?LoginToken
    {
        return Database::getFirst('LoginToken', LoginToken::class, '*', ['token' => "token = '$token'"]);
    }

    public static function create(LoginToken &$entity): bool
    {
        return Database::create('LoginToken', $entity);
    }

    public static function remove(LoginToken $entity): bool
    {
        return Database::remove('LoginToken', $entity);
    }
}