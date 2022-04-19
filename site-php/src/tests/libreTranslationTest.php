<?php

namespace WebtoonLike\tests;


require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\features\Translation\APIs\LibreTranslateTranslation;

$en = new Language('en', 'english', false);
$fr = new Language('fr', 'french', false);

for($i=0; $i < 2; $i++){
    $res = LibreTranslateTranslation::translate('This is a funny test!', $en, $fr);
    var_dump($res);
}