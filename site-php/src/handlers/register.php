<?php

namespace WebtoonLike\Site\handler;

use WebtoonLike\Site\core\Authentication;
use WebtoonLike\Site\core\Router;

if (
    !isset($_POST['password'], $_POST['confirmation_password'], $_POST['email'], $_POST['username'])
    || empty($_POST['password'])
    || empty($_POST['confirmation_password'])
    || empty($_POST['email'])
    || empty($_POST['username'])
) {
    Router::redirect('/register');
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmation_password = $_POST['confirmation_password'];

$res = Authentication::register($username, $email, $password, $confirmation_password);
if (is_bool($res) && $res) {
    Router::redirect('/');
}

Router::redirect('/register', 301, $res);