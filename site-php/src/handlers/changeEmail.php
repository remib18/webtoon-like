<?php

namespace WebtoonLike\Site\handler;

use WebtoonLike\Site\core\Authentication;
use WebtoonLike\Site\core\Router;


if (!isset($_POST['email']) || empty($_POST['email'])) {
    Router::redirect('/user', 301, ['error' => 'Le champ est vide.']);
}

$res = Authentication::editEmail($_SESSION['id'], $_POST['email']);

if($res === true) {
    header("Location: /user");
} else {
    Router::redirect('/user', 301, ['error' => $res]);
}
