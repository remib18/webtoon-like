<?php

namespace WebtoonLike\Site\pageManager;


use WebtoonLike\Site\controller\ChapterController;
use WebtoonLike\Site\controller\ImageController;
use WebtoonLike\Site\controller\LanguageController;
use WebtoonLike\Site\controller\WebtoonController;
use WebtoonLike\Site\core\Router;
use WebtoonLike\Site\entities\Chapter;
use WebtoonLike\Site\entities\Image;
use WebtoonLike\Site\entities\Webtoon;
use WebtoonLike\Site\Settings;

class ImportManager
{

    private static array $acceptedFormat = ['png', 'jpeg', 'jpg'];

    /*
     * Verification de la validité des champs transmis.
     */
    static function CheckNull(): void {

       if (
           !isset($_GET['step'])
           || ((int)$_GET['step'] !== 2 && (int)$_GET['step'] !== 1)
           || (((int)$_GET['step'] === 2 && (!isset($_GET['id']) || !is_numeric($_GET['id']))) && is_null(self::getWebtoon()))
       ){
           Router::redirect('/import', 301, ['step'=>1,'error' => 'Opération impossible']);
       }

    }

    /*
     * Obtenir le Webtoon grace à son id
     */
    private static function getWebtoon(): ?Webtoon {
        return (is_numeric($_GET['id'])) ? WebtoonController::getById((int)$_GET['id']) : null;
    }

    /*
     * Obtention de la bonne section dans import-webtoon.
     */
    static function getStep(): void {
        $step = ((int)$_GET['step']) ?? 1;

        if ($step === 1){
            require dirname(__DIR__, 1) . '/components/import/step1.php';
        } else {
            require dirname(__DIR__, 1) . '/components/import/step2.php';
        }
    }

    /*
     * Nettoyage des chemin
     */
    private static function sanitizePath(string $path): string {
        return preg_replace('/[^A-Za-z0-9._\-]/', '_', $path);
    }

    /*
     * Créer un Webtoon
     */
    static function newWebtoon(): void {
        if (isset($_POST['title'], $_POST['desc'], $_FILES['cover']['name'], $_POST['auteur'])
            && !( empty($_POST['title'])
                || empty($_POST['desc'])
                || empty($_FILES['cover']['name'])
                || empty($_POST['auteur']) )
            ){
           $imageName = self::sanitizePath($_FILES['cover']['name']);
           $webtoon = new Webtoon(
                null,
                htmlentities($_POST['title']),
                htmlentities($_POST['auteur']),
                htmlentities($_POST['desc']),
                $imageName,
                false
            );

            if (!WebtoonController::create($webtoon)) {
                Router::redirect('/import', 301,
                    ['step' => 1, 'error' => 'Nous n\'avons pas réussie à enregistrer le webtoon']
                );
            }
            $id = $webtoon->getId();
            $path = self::saveCover('cover', $id);
            $webtoon->setCover($path);
            WebtoonController::edit($webtoon);
            Router::redirect('/import', 301, ['step' => 2, 'id' => $id]);
        } else {
            Router::redirect('/import', 301,
                ['step' => 1 , 'error' => 'Nous n\'avez pas remplis tous les champs']
            );
        }
    }

    /*
     * Sauvegarde des covers en BDD.
     *
     */
    static function saveCover(string $pic, int $id): string {
        $file = Settings::get('WEBTOONS_IMAGES_FOLDER') . Settings::get('coverFolder');
        if (!file_exists($file)) {
            mkdir($file, 0777, true);
        }

        $tmp_name = $_FILES[$pic]['tmp_name'];
        $name = basename(self::sanitizePath($_FILES[$pic]['name']));
        $location = $file . $id . "_" . $name;

        $imageFormat = strtolower(pathinfo($name,PATHINFO_EXTENSION));
        if (!in_array($imageFormat, self::$acceptedFormat)) {
            $webtoon = WebtoonController::getById($id);
            if (!is_null($webtoon)) WebtoonController::remove($webtoon);
            Router::redirect('/import', 301, ['step' => 1, 'error' => 'Format d\'image non-valide']);
        }

        if (move_uploaded_file($tmp_name,$location)){
            return $id . "_" . $name;
        } else {
            Router::redirect('/error', 301,
                ['msg' => 'Nous n\'avons pas réussie à enregistrer l\'image']
            );
        }
    }

    /*
     * Sauvegarder les chapitres dans la BDD et/ou change la cover du webtoon
     */
    static function saveChapter(): void {
        $webtoonId = (int)$_POST['id'];
        $Chapter = new Chapter(null,
            (int)$_POST['chapter-x-number'],
            htmlentities($_POST['chapter-x-title']),
            $webtoonId,
            false
        );

        if (isset($_FILES['chapter-x-img']['name']) && !empty($_FILES['chapter-x-img']['name'])) {
            $path = ImportManager::saveCover('chapter-x-img', $webtoonId);
            $webtoon = WebtoonController::getById($webtoonId);
            $webtoon->setCover($path);
            WebtoonController::edit($webtoon);
        }

        if (!is_null(ChapterController::getByIndex($webtoonId, (int)$_POST['chapter-x-number']))) {
            Router::redirect('/import', 301,
                ['error' => 'Le chapitre existe déjà','step' => 2, 'id' => $webtoonId]
            );
        }

        if (!ChapterController::create($Chapter)) {
            Router::redirect('/import', 301,
                ['error' => 'Les champs sont incorects','step' => 2, 'id' => $webtoonId]
            );
        }

        $upload = self::uploadImage($Chapter->getId(), (int)$_POST['chapter-x-number']);
        if (!is_bool($upload)) {
            ChapterController::remove($Chapter);
            Router::redirect('/import', 301,
                ['error' => $upload,'step' => 2, 'id' => $webtoonId]
            );
        }

        Router::redirect('/import', 301, ['step' => 2, 'id' => $webtoonId]);
    }

    /*
     * Montre les chapitres du Webtoon
     */
    static function chaptersListForWebtoon(): string {
        $chapList = "";
        $chapterIdByIndex = [];
        $webtoonId = self::getWebtoon()->getId();
        $everyChapter = ChapterController::getAllForWebtoon($webtoonId);
        foreach ($everyChapter as $chapter){
            $chapterIdByIndex[$chapter->getIndex()] = $chapter->getId();
        }
        if (ksort($chapterIdByIndex)) {
            foreach ($chapterIdByIndex as $index => $chapterId) {
                $chapList .= "
             <li>
               Chapitre $index
                <a href='@deleteChapter?chapterId=$chapterId&id=$webtoonId'>
                    <svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 32 32\" class=\"icon\">
                        <path d=\"M27 6H21V4.5C21 3.83696 20.7366 3.20107 20.2678 2.73223C19.7989 2.26339 19.163 2 18.5 2H13.5C12.837 2 12.2011 2.26339 11.7322 2.73223C11.2634 3.20107 11 3.83696 11 4.5V6H5C4.73478 6 4.48043 6.10536 4.29289 6.29289C4.10536 6.48043 4 6.73478 4 7C4 7.26522 4.10536 7.51957 4.29289 7.70711C4.48043 7.89464 4.73478 8 5 8H6.0625L7.25 27.0575C7.33875 28.7356 8.625 30 10.25 30H21.75C23.3831 30 24.6437 28.7638 24.75 27.0625L25.9375 8H27C27.2652 8 27.5196 7.89464 27.7071 7.70711C27.8946 7.51957 28 7.26522 28 7C28 6.73478 27.8946 6.48043 27.7071 6.29289C27.5196 6.10536 27.2652 6 27 6ZM12.0356 26H12C11.7408 26.0002 11.4917 25.8997 11.3052 25.7198C11.1187 25.5399 11.0092 25.2946 11 25.0356L10.5 11.0356C10.4906 10.7704 10.5868 10.5123 10.7677 10.3181C10.9486 10.1239 11.1992 10.0094 11.4644 10C11.7296 9.99055 11.9877 10.0868 12.1819 10.2677C12.3761 10.4486 12.4906 10.6992 12.5 10.9644L13 24.9644C13.0048 25.0957 12.9836 25.2267 12.9377 25.3499C12.8918 25.473 12.8221 25.5859 12.7325 25.6821C12.6429 25.7783 12.5353 25.8559 12.4157 25.9104C12.2961 25.965 12.167 25.9954 12.0356 26ZM17 25C17 25.2652 16.8946 25.5196 16.7071 25.7071C16.5196 25.8946 16.2652 26 16 26C15.7348 26 15.4804 25.8946 15.2929 25.7071C15.1054 25.5196 15 25.2652 15 25V11C15 10.7348 15.1054 10.4804 15.2929 10.2929C15.4804 10.1054 15.7348 10 16 10C16.2652 10 16.5196 10.1054 16.7071 10.2929C16.8946 10.4804 17 10.7348 17 11V25ZM19 6H13V4.5C12.9992 4.43413 13.0117 4.36877 13.0365 4.30777C13.0614 4.24677 13.0982 4.19135 13.1448 4.14477C13.1913 4.09819 13.2468 4.06139 13.3078 4.03652C13.3688 4.01166 13.4341 3.99925 13.5 4H18.5C18.5659 3.99925 18.6312 4.01166 18.6922 4.03652C18.7532 4.06139 18.8087 4.09819 18.8552 4.14477C18.9018 4.19135 18.9386 4.24677 18.9635 4.30777C18.9883 4.36877 19.0008 4.43413 19 4.5V6ZM21 25.0356C20.9908 25.2946 20.8813 25.5399 20.6948 25.7198C20.5083 25.8997 20.2592 26.0002 20 26H19.9638C19.8325 25.9953 19.7034 25.9648 19.5839 25.9102C19.4644 25.8557 19.3568 25.7781 19.2673 25.6819C19.1778 25.5857 19.1081 25.4728 19.0623 25.3497C19.0164 25.2266 18.9952 25.0957 19 24.9644L19.5 10.9644C19.5047 10.8331 19.5352 10.7039 19.5898 10.5844C19.6443 10.4649 19.7219 10.3573 19.8181 10.2677C19.9143 10.1782 20.0271 10.1084 20.1502 10.0625C20.2733 10.0166 20.4043 9.99532 20.5356 10C20.6669 10.0047 20.7961 10.0352 20.9156 10.0898C21.0351 10.1443 21.1427 10.2219 21.2323 10.3181C21.3218 10.4143 21.3916 10.5271 21.4375 10.6502C21.4834 10.7733 21.5047 10.9043 21.5 11.0356L21 25.0356Z\" class=\"fill\"/>
                    </svg>
                </a>
             </li>";
            }
        }
        return $chapList;
    }

    /*
     * Suppression des chapitres.
     */
    static function deleteChapter(): void {
        $Chapter = ChapterController::getById((int)$_GET['chapterId']);
        if (!is_null($Chapter)) {
            $images = ImageController::getByChapterId((int)$_GET['chapterId']);
            foreach ($images as $image){
                ImageController::remove($image);
            }
            ChapterController::remove($Chapter);
        }

        $webtoonId = (int)$_GET['id'];
        Router::redirect('/import', 301, ['step' => 2, 'id' => $webtoonId]);
    }

    /*
     * Upload des images dans le bon dossier.
     */
    static function uploadImage(int $ChapterId, int $indexChapter): string|bool {

        $folder = Settings::get('chapterFolder') . $ChapterId;
        $path = Settings::get('WEBTOONS_IMAGES_FOLDER') . $folder;

        if (!self::checkLanguage($_POST['language'])) {
            return 'Le language choisi n\'est pas vérifiée';
        }
        if (!file_exists($path)) mkdir($path, 0777, true);

        $images = [];
        foreach ($_FILES["chapter-x-parts"]["tmp_name"] as $index => $tmp_name) {
            $name = basename(self::sanitizePath($_FILES["chapter-x-parts"]["name"][$index]));
            $imagePath = "$path/$name";

            $imageFormat = strtolower(pathinfo($name,PATHINFO_EXTENSION));
            if (!in_array($imageFormat, self::$acceptedFormat)) return 'L\'une de vos image à un formart invalide';

            if (!move_uploaded_file($tmp_name, $imagePath)) return 'Verifiez le nom de votre image';

            $BDDpath = "$folder/$name";
            $images[] = new Image(null,
                $indexChapter,
                $BDDpath,
                $ChapterId,
                $_POST["language"],
                null,
                true,
                false
            );
        }

        if (!ImageController::createBatch($images)) return 'Nous avons rencontré des problèmes lors de la sauvegarde des images';

        return true;
    }

    /*
     * Menu de selections des languages sur la page import, step 2.
     */
    static function languageSelect(): void {
        $langs = LanguageController::getAll();
        foreach ($langs as $lang){
            echo '<option value="'.$lang->getIdentifier().'">'.$lang->getName().'</option>';
        }
    }

    /*
     * Vérification que language est bien en BDD.
     */
    static function checkLanguage(string $identifier): bool {
        $languages = LanguageController::getAll();
        foreach ($languages as $language){
            if ($identifier === $language->getIdentifier()) return true;
        }
        return false;
    }
}
