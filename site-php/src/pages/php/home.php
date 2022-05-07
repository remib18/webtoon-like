<?php require dirname(__DIR__, 2) . '/components/header.php'; ?>

<section aria-describedby="#s1-title" id="app">
    <?= WebtoonLike\Site\pageManager\MessageManager::getMessages()?><!--Lorsqu'on à une proposition qui à été transmise-->
    <h2 id="s1-title">Tous les webtoons</h2>
    <div class="webtoons-container" data-search-result-in-page></div>
</section>

<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
