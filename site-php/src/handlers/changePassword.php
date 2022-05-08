<?php

namespace WebtoonLike\Site\handler;

use WebtoonLike\Site\core\Authentication;
use WebtoonLike\Site\core\Router;


if (
    !isset($_POST['password'], $_POST['confirmation_new_password'], $_POST['new_password'])
    || empty($_POST['password'])
    || empty($_POST['new_password'])
    || empty($_POST['confirmation_new_password'])
) {
    Router::redirect('/changePassword', 301, ['error' => 'Un ou plusieurs champ n\'est pas rempli']);
}

$res = Authentication::editPassword(
    $_SESSION['id'],
    $_POST['password'],
    $_POST['new_password'],
    $_POST['confirmation_new_password']
);

if (is_bool($res) && $res) {
    Router::redirect("/changePassword", 301, ['msg' => 'Votre mot de passe a bien été modifié']);
} else {
    Router::redirect('/changePassword', 301, ['error' => $res]);
}
