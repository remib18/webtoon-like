<?php

namespace WebtoonLike\Site\handler;

use WebtoonLike\Site\core\Router;
use WebtoonLike\Site\pageManager\PropositionManager;

if (isset($_GET['TranslationId'], $_GET['BlockId'], $_POST['proposition'])
    && !empty($_POST['proposition'])
    && is_numeric($_GET['BlockId'])
){
    PropositionManager::SaveProposition();
} else {
    Router::redirect('/error', 301, ['msg' => 'Nous n\'avons pas retrouver le texte']);
}


