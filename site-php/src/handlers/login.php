<?php

namespace WebtoonLike\Site\handler;

use WebtoonLike\Site\core\Authentication;
use WebtoonLike\Site\core\Router;

if ( !isset($_POST['email'], $_POST['username']) ) {
    Router::redirect('', '400', [
        'registerError' => 'Un ou plusieurs champs ne sont pas définis.', 'action' => 'login'
    ]);
}

$email = $_POST['email'];
$password = $_POST['password'];

Authentication::login($email, $password);