<?php

namespace WebtoonLike\tests;

ini_set('xdebug.var_display_max_depth', 10);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use WebtoonLike\Site\controller\ChapterController;
use WebtoonLike\Site\controller\ImageController;
use WebtoonLike\Site\controller\LanguageController;
use WebtoonLike\Site\controller\WebtoonController;
use WebtoonLike\Site\entities\Chapter;
use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\entities\Webtoon;
use WebtoonLike\Site\features\Translation\APIs\LibreTranslateTranslation;
use WebtoonLike\Site\features\Translation\OCR\Providers\GoogleOCR;
use WebtoonLike\Site\features\Translation\WebtoonTranslation;


try {
    $webtoon = new Webtoon(null, 'TBA', 'gernjl', 'gnekjgbhezgbhz', false);
    WebtoonController::create($webtoon);

    $chapter = new Chapter(null, 2, 'gneigni', $webtoon->getId(), false);
    ChapterController::create($chapter);

    $english = new Language('en', 'english', false);
    LanguageController::create($english);

    for ($i = 2; $i < 5; $i++) {
        $image = new Image(null, $i - 1, "black-clover/2/$i.jpg", $chapter->getId(), $english->getIdentifier(), null, true, false);
        ImageController::create($image);
    }
} catch (\Exception) {}

$ocr = new WebtoonTranslation(GoogleOCR::class, LibreTranslateTranslation::class);

$res = $ocr->getTranslatedWebtoonImages(1, 2, new Language('fr', 'french', false));

var_dump($res);