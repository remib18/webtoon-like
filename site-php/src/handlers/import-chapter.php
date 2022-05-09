<?php


use WebtoonLike\Site\core\Router;
use WebtoonLike\Site\pageManager\ImportManager;


if (!(isset($_POST['chapter-x-title'], $_POST['chapter-x-number'], $_POST['id'], $_POST['language'])
    && !(empty($_POST['chapter-x-title']) || empty($_POST['chapter-x-number']) || empty($_POST['id']) || empty($_POST['language']))
    && is_numeric($_POST['chapter-x-number']) && is_numeric($_POST['id']))
) {
    Router::redirect('/error', 301, ['msg' => 'Aucun chapitre soumis ou champ manquant']);
}

importManager::saveChapter();

