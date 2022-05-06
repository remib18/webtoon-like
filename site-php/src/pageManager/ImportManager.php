<?php

namespace WebtoonLike\Site\pageManager;


use WebtoonLike\Site\controller\ChapterController;
use WebtoonLike\Site\controller\WebtoonController;
use WebtoonLike\Site\core\Router;
use WebtoonLike\Site\entities\Chapter;
use WebtoonLike\Site\entities\Webtoon;

class ImportManager
{
    static ?array $chapList=null;
    static ?array $chapters = null;
    static ?array $chapterNum = null;
    static ?array $image = null;


    static function getStep(): void{
        $step=((int)$_GET['step'])??1;

        if($step===1){
            require dirname(__DIR__, 1) . '/components/import/step1.php';
        }else{
            require dirname(__DIR__, 1) . '/components/import/step2.php';
        }
    }

    /*
     *Creer un Webtoon
     */
    static function newWebtoon(): void {
        if(isset($_POST['title'])
            && isset($_POST['desc'])
            && isset($_FILES['cover']['name'])
            && isset($_POST['auteur'])
            && !( empty($_POST['title'])
                || empty($_POST['desc'])
                || empty($_FILES['cover']['name'])
                || empty($_POST['auteur']) )
            ){
            $Webtoon = new Webtoon(null,$_POST['title'],$_POST['auteur'],$_POST['desc'],$_FILES['cover']['name'],false);
            if(WebtoonController::create($Webtoon)) {
            }else{
                Router::redirect('/import', 301, ['step'=>1,'msg' => 'Nous n\'avons pas réussie à enregistrer le webtoon']);
            }
            $Id= $Webtoon->getId();
            $path=self::saveCover('cover',$Id);
            $Webtoon->setCover($path);
            WebtoonController::edit($Webtoon);
            header('Location: /import?step=2');
        }else{
            Router::redirect('/import?step=1', 301, ['step'=>1,'msg' => 'Nous n\'avez pas remplis tous les champs']);
        }
    }

    static function uploadImage():void{
        $uploads_dir = '/assets/pictures/'.getName().'/'.chapNum();
        foreach ($_FILES["pictures"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
                // basename() peut empêcher les attaques de système de fichiers;
                // la validation/assainissement supplémentaire du nom de fichier peut être approprié
                $name = basename($_FILES["pictures"]["name"][$key]);
                move_uploaded_file($tmp_name, "$uploads_dir/$name");
            }
        }
    }
    static function saveCover(string $pic, int $Id): string{
        $file = '../assets/webtoons-imgs/';
        if(!file_exists($file)) {
            mkdir($file, 0777, true);
        }

        $tmp_name = $_FILES[$pic]['tmp_name'];
        $name = basename($_FILES[$pic]['name']);
        $location =$file.$Id."_".$name;
        if(move_uploaded_file($tmp_name,$location)){
            return $Id."_".$name;
        }else{
            Router::redirect('/error', 301, ['msg' => 'Nous n\'avons pas réussie à enregistrer l\'image']);
        }
    }

    /*static function saveChapter():void {

        $Id= self::getId();
         foreach (self::$chapters as $Chapter) {
            $index = $Chapter[0];
            $titre = $Chapter[1];
            $Chapter = new Chapter(null, $index, $titre, $Id, false);
            if (ChapterController::create($Chapter)) {
            } else {
                Router::redirect('/error', 301, ['msg' => 'Nous n\'avons pas réussie à enregistrer un chapitre']);
            }
         }
    }*/


    static function chapListMaj(): void
    {
        if (isset($_POST['chapter-x-parts']))
        {
            self::$chapterNum = $_POST['chapter-x-number'];
        }
        foreach (self::$chapterNum as $num) {
            self::$chapList="
             <li>
                   Chapitre ' . $num . '
                    <a href=\"\">
                        <svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 32 32\" class=\"icon\">
                            <path d=\"M27 6H21V4.5C21 3.83696 20.7366 3.20107 20.2678 2.73223C19.7989 2.26339 19.163 2 18.5 2H13.5C12.837 2 12.2011 2.26339 11.7322 2.73223C11.2634 3.20107 11 3.83696 11 4.5V6H5C4.73478 6 4.48043 6.10536 4.29289 6.29289C4.10536 6.48043 4 6.73478 4 7C4 7.26522 4.10536 7.51957 4.29289 7.70711C4.48043 7.89464 4.73478 8 5 8H6.0625L7.25 27.0575C7.33875 28.7356 8.625 30 10.25 30H21.75C23.3831 30 24.6437 28.7638 24.75 27.0625L25.9375 8H27C27.2652 8 27.5196 7.89464 27.7071 7.70711C27.8946 7.51957 28 7.26522 28 7C28 6.73478 27.8946 6.48043 27.7071 6.29289C27.5196 6.10536 27.2652 6 27 6ZM12.0356 26H12C11.7408 26.0002 11.4917 25.8997 11.3052 25.7198C11.1187 25.5399 11.0092 25.2946 11 25.0356L10.5 11.0356C10.4906 10.7704 10.5868 10.5123 10.7677 10.3181C10.9486 10.1239 11.1992 10.0094 11.4644 10C11.7296 9.99055 11.9877 10.0868 12.1819 10.2677C12.3761 10.4486 12.4906 10.6992 12.5 10.9644L13 24.9644C13.0048 25.0957 12.9836 25.2267 12.9377 25.3499C12.8918 25.473 12.8221 25.5859 12.7325 25.6821C12.6429 25.7783 12.5353 25.8559 12.4157 25.9104C12.2961 25.965 12.167 25.9954 12.0356 26ZM17 25C17 25.2652 16.8946 25.5196 16.7071 25.7071C16.5196 25.8946 16.2652 26 16 26C15.7348 26 15.4804 25.8946 15.2929 25.7071C15.1054 25.5196 15 25.2652 15 25V11C15 10.7348 15.1054 10.4804 15.2929 10.2929C15.4804 10.1054 15.7348 10 16 10C16.2652 10 16.5196 10.1054 16.7071 10.2929C16.8946 10.4804 17 10.7348 17 11V25ZM19 6H13V4.5C12.9992 4.43413 13.0117 4.36877 13.0365 4.30777C13.0614 4.24677 13.0982 4.19135 13.1448 4.14477C13.1913 4.09819 13.2468 4.06139 13.3078 4.03652C13.3688 4.01166 13.4341 3.99925 13.5 4H18.5C18.5659 3.99925 18.6312 4.01166 18.6922 4.03652C18.7532 4.06139 18.8087 4.09819 18.8552 4.14477C18.9018 4.19135 18.9386 4.24677 18.9635 4.30777C18.9883 4.36877 19.0008 4.43413 19 4.5V6ZM21 25.0356C20.9908 25.2946 20.8813 25.5399 20.6948 25.7198C20.5083 25.8997 20.2592 26.0002 20 26H19.9638C19.8325 25.9953 19.7034 25.9648 19.5839 25.9102C19.4644 25.8557 19.3568 25.7781 19.2673 25.6819C19.1778 25.5857 19.1081 25.4728 19.0623 25.3497C19.0164 25.2266 18.9952 25.0957 19 24.9644L19.5 10.9644C19.5047 10.8331 19.5352 10.7039 19.5898 10.5844C19.6443 10.4649 19.7219 10.3573 19.8181 10.2677C19.9143 10.1782 20.0271 10.1084 20.1502 10.0625C20.2733 10.0166 20.4043 9.99532 20.5356 10C20.6669 10.0047 20.7961 10.0352 20.9156 10.0898C21.0351 10.1443 21.1427 10.2219 21.2323 10.3181C21.3218 10.4143 21.3916 10.5271 21.4375 10.6502C21.4834 10.7733 21.5047 10.9043 21.5 11.0356L21 25.0356Z\" class=\"fill\"/>
                        </svg>
                    </a>
                 </li>";
            }
    }




}




