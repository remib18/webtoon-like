<?php

namespace WebtoonLike\Site\handler;

use WebtoonLike\Site\core\Authentication;
use WebtoonLike\Site\core\Router;

if ( !isset($_POST['email'], $_POST['password']) ) {
    Router::redirect('/login', 301, ['msg' => 'Vous devez remplir TOUS les champs.']);
}

$email = $_POST['email'];
$password = $_POST['password'];

Authentication::login($email, $password);