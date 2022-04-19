<?php

namespace WebtoonLike\tests;


require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\features\Translation\APIs\AzureTranslation;

$es = new Language('es', 'japanese', false);
$fr = new Language('fr', 'french', false);


$res = AzureTranslation::translate("Voici un test qui fonctionne.", $fr, $es);
var_dump($res);

$list = [
    'WHICH OF FIRST BECOMES',
    'THE SORCERY EMPEROR !!!',
    'AN OATH BETWEEN MEN!!'
];

$res = AzureTranslation::translateMany(
    $list,
    new Language('en', '', false),
    new Language('fr', '', false)
);

var_dump($res);