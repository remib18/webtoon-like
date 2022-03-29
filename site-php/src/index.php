<?php

use WebtoonLike\SitePhp\utils\PageUtils;

require './utils/PageUtils.php';

$p = new PageUtils();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4A5353">

    <title><?= $p->getPageTitle() ?></title>

    <?= $p->getStylesheets() ?>
    <?= $p->getScripts() ?>
</head>
<body>

<header>
    <h1 class="logo">WebtoonLike</h1>
    <fieldset>
        <label for="search">Rechercher</label>
        <input type="search" name="search" id="search" placeholder="Rechercher" data-searchbar>
        <div class="search-result" data-search-result></div>
    </fieldset>
    <div class="icons">
        <a href="/import?t=webtoon">
            <svg class="icon" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 22.9869H24.75C28.1875 22.9869 31 21.1612 31 17.7619C31 14.3625 27.6875 12.67 25 12.5369C24.4444 7.22062 20.5625 3.98688 16 3.98688C11.6875 3.98688 8.91 6.84875 8 9.68687C4.25 10.0431 1 12.4294 1 16.3369C1 20.2444 4.375 22.9869 8.5 22.9869H12" class="stroke" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M16 28.0132V12.9869M20 15.9869L16 11.9869L12 15.9869H20Z" class="stroke" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <a href="#">
            <svg class="icon" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 3C8.83187 3 3 8.83187 3 16C3 23.1681 8.83187 29 16 29C23.1681 29 29 23.1681 29 16C29 8.83187 23.1681 3 16 3ZM12.8612 10.3013C13.6531 9.46188 14.7675 9 16 9C17.2325 9 18.3369 9.465 19.1319 10.3088C19.9375 11.1638 20.3294 12.3125 20.2369 13.5475C20.0519 16 18.1519 18 16 18C13.8481 18 11.9444 16 11.7631 13.5469C11.6713 12.3019 12.0625 11.1494 12.8612 10.3013V10.3013ZM16 27C14.5315 27.001 13.0778 26.7071 11.7251 26.1357C10.3724 25.5643 9.14813 24.7271 8.125 23.6737C8.71097 22.8381 9.4576 22.1276 10.3212 21.5837C11.9144 20.5625 13.9306 20 16 20C18.0694 20 20.0856 20.5625 21.6769 21.5837C22.5412 22.1273 23.2885 22.8379 23.875 23.6737C22.852 24.7272 21.6277 25.5645 20.275 26.1359C18.9222 26.7073 17.4685 27.0011 16 27V27Z" fill="white" fill-opacity="0.8"/>
            </svg>
        </a>
    </div>
</header>

<?= $p->getPage() ?>

<footer>
    <!-- Todo: Compléter -->
    <p>
        Projet universitaire par <a href="https://github.com/remib18">Rémi Bernard</a>,
        Projet universitaire par <a href="https://github.com/"></a>,
        Projet universitaire par <a href="https://github.com/"></a>,
        Projet universitaire par <a href="https://github.com/"></a>
    </p>
</footer>

<template data-item-result-template>
    <a href="" class="webtoon">
        <img src="https://via.placeholder.com/150x200" alt="cover">
        <span class="webtoon-title">Title</span>
    </a>
</template>

</body>
</html>