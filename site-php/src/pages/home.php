<?php
namespace WebtoonLike\Site\page;
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use WebtoonLike\Site\pageManager\HomeManager;

#<div class="webtoons-container" data-search-result-in-page></div>
?>

<section aria-describedby="#s1-title" id="app">
    <h2 id="s1-title">Tous les webtoons</h2>
    <div class="webtoons-container"> <?= (new HomeManager)->HomePage() ?> </div>
</section>