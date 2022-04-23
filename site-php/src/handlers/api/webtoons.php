<?php

namespace WebtoonLike\Site\handlers\api;

require_once dirname(__DIR__, 3) . '/vendor/autoload.php';

use WebtoonLike\Site\controller\WebtoonController;

$webtoons = WebtoonController::getAll();

$res = [];

foreach ($webtoons as $webtoon) {
    $res[] = [
        'id'    => $webtoon->getId(),
        'title' => $webtoon->getName(),
        'cover' => $webtoon->getCover()
    ];
}

echo json_encode($res);