<?php

namespace WebtoonLike\tests;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use WebtoonLike\Site\controller\WebtoonController;
use WebtoonLike\Site\entities\Webtoon;
use WebtoonLike\Site\utils\Database;


$testId = 6;

if (!WebtoonController::exists($testId)) {
    $webtoon = new Webtoon(null, 'TBA', 'fz,lf,ze', 'Best webtoon ever.');
    var_dump($webtoon);
    $res = WebtoonController::create($webtoon);
    var_dump($res);
    var_dump($webtoon);
}

var_dump(WebtoonController::getById($testId));

$res = WebtoonController::getAll();
var_dump($res);

var_dump(WebtoonController::remove($res[0]));

$edit = $res[1];
$edit->setName('aaaaa');
var_dump(WebtoonController::edit($edit));

var_dump(WebtoonController::getByName('TBA'));
