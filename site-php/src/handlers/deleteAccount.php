<?php

namespace WebtoonLike\Site\handler;

use WebtoonLike\Site\core\Authentication;
use WebtoonLike\Site\core\deleteAccount;
use WebtoonLike\Site\core\Router;

if ( !isset($_POST['deleteAccount'], $_POST['password'], $_SESSION['id'])
    || empty($_POST['deleteAccount'])
    || empty($_POST['password'])) {

    Router::redirect('/deleteAccount', 301, ['errorChampVide' => 'Veuillez saisir les champs']);
}

$res = deleteAccount::deleteAccount($_SESSION['id'], $_POST['password']);

if($res) {
    Authentication::logout();
} else {
    Router::redirect('/deleteAccount', 301, ['errorDeletion' => $res]);
}
