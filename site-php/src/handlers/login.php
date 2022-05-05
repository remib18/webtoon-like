<?php

namespace WebtoonLike\Site\handler;

use WebtoonLike\Site\core\Authentication;
use WebtoonLike\Site\core\Router;

if ( !isset($_POST['email'], $_POST['password'])
    || empty($_POST['email'])
    || empty($_POST['password'])) {

    Router::redirect('/login', 301, ['errorChamp' => 'Vous devez remplir TOUS les champs']);
}

$email = $_POST['email'];
$password = $_POST['password'];
$rememberMe = false;

if(isset($_POST['rememberMe'])) {
    $rememberMe = true;
}

$res = Authentication::login($email, $password, $rememberMe);

if(is_bool($res) && $res) {
    header("Location: /");
} else {
    Router::redirect('/login', 301, ['errorAuth' => $res]);
}
