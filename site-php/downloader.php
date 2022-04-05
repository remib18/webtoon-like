<?php

namespace Root;

require_once __DIR__ . '/vendor/autoload.php';

function BC_C2_dwl(int $frame) {
    $uri = 'https://cdn.bakihanma.com/file/Zolyvmanga/black-clover/Chapter-2-:-The-Magic-Knights-Entrance-Exam/' . $frame . '.jpg';
    $downloader = new \greeflas\tools\ImageDownloader([
        'class' => \greeflas\tools\validators\ImageValidator::class
    ]);
    $downloader->download($uri, __DIR__ . '/assets/webtoons-imgs/black-clover/2', $frame . '.jpg');
}
$i = 0;
while (true) {
    try {
        BC_C2_dwl($i);
    } catch (\Exception $e) {
        break;
    }
    $i++;
}