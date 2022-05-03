<?php

namespace WebtoonLike\Site\handler;

use WebtoonLike\Site\core\Router;
use WebtoonLike\Site\pageManager\PropositionManager;


if(isset($_POST['proposition'])) {
    PropositionManager::SaveProposition();
}


