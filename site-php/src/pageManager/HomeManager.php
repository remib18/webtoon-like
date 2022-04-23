<?php


namespace WebtoonLike\Site\pageManager;

use WebtoonLike\Site\controller\ChapterController;
use WebtoonLike\Site\controller\WebtoonController;
use WebtoonLike\Site\entities\Webtoon;

class HomeManager
{
    static $AllWebtoon = [];

    private static function getAllWebtoon(): Webtoon
    {
        return self::$AllWebtoon = WebtoonController::getAll();

    }

    public function getName(Webtoon $Webtoon): string
    {
        return $Webtoon->getName();
    }

    /*
     * Renvoie le covers !!!!rajouter le path dans table webtoon!!!!!
     */
    public function getImage(Webtoon $Webtoon): string
    {
        return $Webtoon->getImage();
    }

    public function getId($Webtoon): int
    {
        return $Webtoon->getId();
    }

    public function getChapterId($WebtoonId): int
    {
        $chapterId = ChapterController::getByIndex($WebtoonId, 1);
        if (ChapterController::exists($chapterId)) {
            return $chapterId;
        }
        header('Location: /');
        return 0;### A Revoir ####
    }

    public function HomePage()
    {
        $ALL = self::$AllWebtoon;
        $res = "";

        foreach ($ALL as $Webtoon) {
            $webtoonId = getId($Webtoon);
            $webtoonCover = getImage($Webtoon);
            $chapterId = getChapterId($Webtoon);
            $name = getName($Webtoon);
            $res .= '<a href = "localhost/webtoon?id=' . $webtoonId . '&chapter=' . $chapterId . '" class = "webtoon">
            <img src = "' . $webtoonCover . '" alt = "cover">
            <span class = "webtoon-title">"' . $name . '"</span>
            </a>';
        }

        return $res;
    }

}
