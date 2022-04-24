<?php

namespace WebtoonLike\Site\handler;

use WebtoonLike\Site\core\Authentication;
use WebtoonLike\Site\core\Router;

if ( !isset($_POST['email'], $_POST['username']) ) {
    Router::redirect('/#login');
}

$email = $_POST['email'];
$password = $_POST['password'];

Authentication::login($email, $password);