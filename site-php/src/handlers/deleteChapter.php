<?php


use WebtoonLike\Site\core\Router;
use WebtoonLike\Site\pageManager\ImportManager;

if (isset($_GET['id'], $_GET['chapterId'])) {
    ImportManager::deleteChapter();
} else {
    Router::redirect('/error', 301, ['msg' => 'Ce webtoon n\'éxiste pas']);
}
