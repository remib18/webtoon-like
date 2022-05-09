<?php

require_once dirname(__DIR__, 3) . '/vendor/autoload.php';

use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\exceptions\AlreadyExistingRessourceException;
use WebtoonLike\Site\exceptions\ApiException;
use WebtoonLike\Site\exceptions\NotFoundException;
use WebtoonLike\Site\exceptions\TranslationException;
use WebtoonLike\Site\features\Translation\APIs\AzureTranslation;
use WebtoonLike\Site\features\Translation\OCR\Providers\Google\GoogleOCR;
use WebtoonLike\Site\features\Translation\WebtoonTranslation;

// header('Content-Type: application/json');

//try {

// validate request
if (!isset($_GET['webtoon'], $_GET['chapter'], $_GET['language'])) {
    $res = [
        'errors' => [
            'You must specify the following keys : webtoon, chapter, language'
        ]
    ];
    echo json_encode($res);
    die;
}

$errors = [];
$data = [];

try {
    $lang = new Language($_GET['language'], '');
    $data = ( new WebtoonTranslation(GoogleOCR::class, AzureTranslation::class) )
        ->getTranslatedWebtoonImages((int)$_GET['webtoon'], (int)$_GET['chapter'], $lang);
} catch (AlreadyExistingRessourceException|TranslationException|NotFoundException|ApiException $e) {
    $errors[] = $e->getMessage();
}

if (( $data['status'] ?? '' ) === 'UNAUTHENTICATED') {
    $errors[] = '';
}

$res = [];
foreach ($data as $item) {
    $res[] = $item->__toArray();
}

echo json_encode([
                     'errors' => sizeof($errors) > 0 ? $errors : null,
                     'data'   => sizeof($errors) > 0 ? null : $res
                 ]);

/*} catch (Exception | Error $e) {
    $prodError = 'Erreur serveur interne, si le problème persiste, contactez l\'administrateur';
    echo json_encode(
        [
            'errors' => \WebtoonLike\Site\Settings::get('production') ? $prodError : $e
        ]
    );
}*/