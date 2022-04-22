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

    /**
     * @return Router
     */
    private static function getRouter(): Router {
        if (is_null(self::$router)) self::$router = new Router();
        return self::$router;
    }

    /**
     * L'utilisateur a-t-il l'accès à la ressource ?
     *
     * @return bool
     */
    private static function isRessourceAccessibleForUser(): bool {
        return Authentication::hasAccess();
    }

    /**
     * Effectue le routing
     *
     * @param RouterMode $mode
     * @param array|null $data
     *
     * @return void
     */
    public static function route(RouterMode $mode, ?array $data): void {
        if (!self::isRessourceAccessibleForUser()) {
            self::redirect('', 403, [], '#register');
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

    /**
     * Routing avec le moteur de template
     *
     * @param array $data
     *
     * @return void
     */
    private function pureHTMLRouting(array $data): void {
        // TODO: [TemplateEngine] @MPXH
        try {
            echo TemplateEngine::load($this->pageType, $data);
        } catch (NotFoundException) { self::notFound(); }
    }

    /**
     * Routing de fichiers php
     *
     * @param bool $isHandler
     *
     * @return void
     */
    private function generatedHTMLRouting(bool $isHandler = false): void {
        $ressourceLocation = $isHandler ? 'HANDLERS_FOLDER' : 'GENERATED_PAGES_FOLDER';
        $pageType = $isHandler ? substr($this->pageType, 1) : $this->pageType;

        $path = Settings::get('ROUTER')[$ressourceLocation] . $pageType . '.php';
        if (!file_exists($path)) self::notFound();
        require $path;
    }

    /**
     * Effectue une redirection
     *
     * @param string $url
     * @param array  $getParams
     * @param string $htmlId
     *
     * @return void
     */
    #[NoReturn] public static function redirect(string $url, int $code = 301, array $getParams = [], string $htmlId = ''): void {
        header(
            'Location: ' . $url . UriUtils::buildUriGetParamsFromArray($getParams) . $htmlId,
            true, $code
        );
        die;
    }

    /**
     * Redirection vers la page d'erreur 404
     *
     * @return void
     */
    #[NoReturn] private static function notFound(): void {
        self::redirect('/error', 404, [
            'code' => 404,
            'msg' => 'La pas demandée n\'existe pas.'
        ]);
    }



}