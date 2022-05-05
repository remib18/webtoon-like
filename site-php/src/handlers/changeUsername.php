<?php

namespace WebtoonLike\Site\handler;

use WebtoonLike\Site\core\editAccount;
use WebtoonLike\Site\core\Router;


if (!isset($_POST['username']) || empty($_POST['username'])) {
    Router::redirect('/user', 301, ['error' => 'Le champ est vide.']);
}

$res = editAccount::editUsername($_SESSION['id'], $_POST['username']);

if($res === true) {
    header("Location: /user");
} else {
    Router::redirect('/user', 301, ['error' => $res]);
}
