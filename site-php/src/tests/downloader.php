<?php

namespace WebtoonLike\tests;

use Exception;
use greeflas\tools\ImageDownloader;
use greeflas\tools\validators\ImageValidator;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

function BC_C2_dwl(int $frame)
{
    $uri = 'https://cdn.bakihanma.com/file/Zolyvmanga/black-clover/Chapter-2-:-The-Magic-Knights-Entrance-Exam/' . $frame . '.jpg';
    $downloader = new ImageDownloader([
        'class' => ImageValidator::class
    ]);
    $downloader->download($uri, __DIR__ . '/assets/webtoons-imgs/black-clover/2', $frame . '.jpg');
}

$i = 0;
while (true) {
    try {
        BC_C2_dwl($i);
    } catch (Exception $e) {
        break;
    }
    $i++;
}