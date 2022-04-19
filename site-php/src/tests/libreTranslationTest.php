<?php

namespace WebtoonLike\tests;


require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\features\Translation\APIs\LibreTranslateTranslation;

$ja = new Language('ja', 'japanese', false);
$fr = new Language('fr', 'french', false);


$res = LibreTranslateTranslation::translate("Voici un test qui fonctionne.", $fr, $ja);
echo $res;