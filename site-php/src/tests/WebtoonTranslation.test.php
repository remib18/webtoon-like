<?php

namespace WebtoonLike\tests;

ini_set('xdebug.var_display_max_depth', 10);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use WebtoonLike\Site\controller\ImageController;
use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\features\Translation\APIs\AzureTranslation;
use WebtoonLike\Site\features\Translation\OCR\Providers\Google\GoogleOCR;
use WebtoonLike\Site\features\Translation\WebtoonTranslation;
use WebtoonLike\Site\utils\Database;

try { // Run this once and comment
    $q = "INSERT INTO Webtoon VALUES (1, 'name', 'author', 'desc'); INSERT INTO Chapter VALUES (1, 1, 'title', 1); INSERT INTO `Language` VALUES ('en', 'english');";
    Database::getDB()->query($q);
    for ($i = 2; $i < 5; $i++) {
        $image = new Image(null, $i - 1, "black-clover/2/$i.jpg", 1, 'en', null, true, false);
        ImageController::create($image);
    }
} catch (\Exception) {}

$ocr = new WebtoonTranslation(GoogleOCR::class, AzureTranslation::class);

$res = $ocr->getTranslatedWebtoonImages(1, 1, new Language('fr', '', false));

var_dump($res);