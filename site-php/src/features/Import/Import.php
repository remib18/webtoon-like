<?php

namespace WebtoonLike\Site\features\Import;

use greeflas\tools\exceptions\NotAllowedFileExtensionException;
use greeflas\tools\ImageDownloader;
use greeflas\tools\validators\ImageValidator;
use WebtoonLike\Site\controller\ChapterController;
use WebtoonLike\Site\controller\ImageController;
use WebtoonLike\Site\exceptions\AlreadyExistingRessourceException;
use WebtoonLike\Site\exceptions\NotFoundException;
use function Root\BC_C2_dwl;

define('base_images_folder', dirname(__DIR__, 3) . '/assets/webtoons-imgs/');

class Import
{

    /**
     * @param int $webtoonId
     * @param int $chapter
     *
     * @return bool | int
     *
     * @throws NotFoundException|AlreadyExistingRessourceException
     */
    public static function load(int $webtoonId, int $chapter): false | int {
        // TODO make it work for any webtoon / cdn
        // currently only provide one manga scan for tests purpose

        if (ChapterController::exists($webtoonId, $chapter)) {
            throw new AlreadyExistingRessourceException();
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
        if ($i === 0) {
            throw new NotFoundException();
        }

        $chapterId = ChapterController::create([
            'number' => $chapter,
            'title' => '',
            'webtoonID' => $webtoonId
        ]);

        for ($j = 0; $j < $i; $j++) {
            ImageController::create([
                'position' => $j,
                'path' => 'file://' . base_images_folder . "$webtoonId/$chapter/$j.jpg",
                'chapterID' => $chapterId
            ]);
        }

        return $chapterId;
    }

    /**
     * @return array<string>
     */
    public static function getCDNPile(): array {
        // TODO: Implement getCDNPile() method.
        return [''];
    }

    /**
     * @param string $name
     * @param int $chapter
     * @param int $frame
     * @return void
     * @throws NotAllowedFileExtensionException
     */
    public static function loadImage(string $name, int $chapter, int $frame): void {
        $uri = 'https://cdn.bakihanma.com/file/Zolyvmanga/black-clover/Chapter-2-:-The-Magic-Knights-Entrance-Exam/' . $frame . '.jpg';
        $downloader = new ImageDownloader([
            'class' => ImageValidator::class
        ]);
        $downloader->download($uri, base_images_folder . 'black-clover/2', $frame . '.jpg');
    }

}