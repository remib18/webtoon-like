<?php


use WebtoonLike\Site\core\Router;

if(isset($_GET['id'],$_GET['chapterId'])
    && is_numeric($_GET['id']) && is_numeric($_GET['chapterId'])
){
    \WebtoonLike\Site\pageManager\ImportManager::deleteChapter();
}else{
    Router::redirect('/error', 301, ['msg' => 'Ce webtoon n\'éxiste pas']);
}
