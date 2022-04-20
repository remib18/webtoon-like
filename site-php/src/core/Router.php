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
        return true;
    }

    public static function route(RouterMode $mode, ?array $data): void {
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
        try {
            echo TemplateEngine::load($this->pageType, $data);
        } catch (NotFoundException) { self::notFound(); }
    }

    private function generatedHTMLRouting(): void {
        $path = Settings::get('ROUTER')['GENERATED_FOLDER'] . $this->pageType . '.php';
        if (!file_exists($path)) self::notFound();
        require $path;
    }

    #[NoReturn] private static function notFound(): void {
        header(
            'Location: /error?code=404&msg='
            . urlencode('La page demandée n\'existe pas.')
        );
        die;
    }



}