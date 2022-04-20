<?php

namespace WebtoonLike\tests;

ini_set('xdebug.var_display_max_depth', 10);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\features\Translation\OCR\Providers\Google\GoogleOCR;


$ocr = new GoogleOCR();

// Single Test
$ocr->registerImage(new Image(0, 5, makePath(5), 2));
$singleRes = $ocr->runOCR();
var_dump($singleRes);

// Batch Test
/*for ($i = 1; $i < 10; $i++) {
    $ocr->registerImage(new Image($i, $i, makePath($i), 2));
}
var_dump($ocr->runOCR());*/

function makePath(int $i): string {
    return "black-clover/2/$i.jpg";
}