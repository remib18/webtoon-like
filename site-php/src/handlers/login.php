<?php

namespace WebtoonLike\Site\handler;

use WebtoonLike\Site\core\Authentication;
use WebtoonLike\Site\core\Router;

if ( !isset($_POST['email'], $_POST['password'])
    || empty($_POST['email'])
    || empty($_POST['password'])) {
    Router::redirect('/login', 301, ['msg' => 'Vous devez remplir TOUS les champs.']);
}

$email = $_POST['email'];
$password = $_POST['password'];

$res = Authentication::login($email, $password);
if($res === true) {
    Router::redirect('/'); // Todo: ajout element target
}

Router::redirect('/login', null, [$res]);
