<?php

    namespace WebtoonLike\Site\handler;

    use WebtoonLike\Site\core\Authentication;
    use WebtoonLike\Site\core\Router;

    if ( !isset($_POST['password'], $_POST['confirmation_password'], $_POST['email'], $_POST['username']) ) {
        Router::redirect('', '400', [
            'registerError' => 'Un ou plusieurs champs ne sont pas définis.', 'action' => 'register'
        ]);
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmation_password = $_POST['confirmation_password'];

    Authentication::register($username, $email, $password, $confirmation_password);