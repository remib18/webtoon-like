<?php

namespace WebtoonLike\Site\components;

use WebtoonLike\Site\utils\PageUtils;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4A5353">

    <title><?= PageUtils::getPageTitle() ?></title>

    <?= PageUtils::getStylesheets() ?>
    <?= PageUtils::getScripts() ?>
</head>
<body>

<header>
    <?= PageUtils::getLogo() ?>
    <fieldset>
        <label for="search">Rechercher</label>
        <input type="search" name="search" id="search" placeholder="Rechercher" data-searchbar>
        <div class="search-result" data-search-result></div>
    </fieldset>
    <nav class="icons">
        <ul>
            <?= PageUtils::getNavigation() ?>
        </ul>
    </nav>
</header>