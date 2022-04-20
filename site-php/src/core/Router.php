<?php

namespace WebtoonLike\Site\core;

use JetBrains\PhpStorm\NoReturn;
use WebtoonLike\Site\exceptions\NotFoundException;
use WebtoonLike\Site\Settings;
use WebtoonLike\Site\utils\UriUtils;

class Router
{

    private static ?Router $router = null;

    private string $pageType;

    private function __construct() {
        $this->pageType = UriUtils::getPageType();
    }

    private static function getRouter(): Router {
        if (is_null(self::$router)) self::$router = new Router();
        return self::$router;
    }

    private static function isRessourceAccessibleForUser(): bool {
        // TODO: [User system] @gabey
        // note: utilises self::getRouter()->pageType pour savoir le template
        return true;
    }

    public static function route(RouterMode $mode, ?array $data): void {
        if (!self::isRessourceAccessibleForUser()) {
            self::redirect('', [], '#register');
        }

        if (UriUtils::isHandler()) {
            self::getRouter()->generatedHTMLRouting(true);
            return;
        }

        switch ($mode) {
            case RouterMode::PURE_HTML:
                self::getRouter()->pureHTMLRouting($data);
                break;
            case RouterMode::GENERATED_HTML:
                self::getRouter()->generatedHTMLRouting();
                break;
        }
    }

    private function pureHTMLRouting(array $data): void {
        // TODO: [TemplateEngine] @MPXH
        try {
            echo TemplateEngine::load($this->pageType, $data);
        } catch (NotFoundException) { self::notFound(); }
    }

    private function generatedHTMLRouting(bool $isHandler = false): void {
        $ressourceLocation = $isHandler ? 'HANDLERS_FOLDER' : 'GENERATED_PAGES_FOLDER';
        $pageType = $isHandler ? substr($this->pageType, 1) : $this->pageType;

        $path = Settings::get('ROUTER')[$ressourceLocation] . $pageType . '.php';
        if (!file_exists($path)) self::notFound();
        require $path;
    }

    #[NoReturn] public static function redirect(string $url, array $getParams = [], string $htmlId = ''): void {
        header('Location: ' . $url . UriUtils::buildUriGetParamsFromArray($getParams) . $htmlId);
        die;
    }

    #[NoReturn] private static function notFound(): void {
        self::redirect('/error', [
            'code' => 404,
            'msg' => 'La pas demandée n\'existe pas.'
        ]);
    }



}