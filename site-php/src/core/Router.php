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

    private static bool $redirected = false;

    public static ?string $ERROR = null;

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
     * @param bool        $isHandler
     * @param string|null $forcePageTemplate
     *
     * @return void
     */
    private function generatedHTMLRouting(bool $isHandler = false, ?string $forcePageTemplate = null): void {
        $ressourceLocation = $isHandler ? 'HANDLERS_FOLDER' : 'GENERATED_PAGES_FOLDER';
        $pageType = $isHandler ? substr($this->pageType, 1) : $this->pageType;
        $pageType = $forcePageTemplate ?? $pageType;

        $path = Settings::get('ROUTER')[$ressourceLocation] . $pageType . '.php';
        if (!file_exists($path)) self::notFound();
        require $path;
    }

    /**
     * Effectue une redirection
     *
     * @param string $url       Destination de la redirection
     * @param int    $code      Code d'erreur HTTP
     * @param array  $getParams Paramètres $_GET à fournir à la redirection
     * @param string $htmlId    Identifiant HTML
     *
     * @return void
     */
    #[NoReturn] public static function redirect(string $url, int $code = 301, array $getParams = [], string $htmlId = ''): void {
        if (self::$redirected) return;
        self::$redirected = true;
        self::getRouter()->generatedHTMLRouting(false, 'error');
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
    #[NoReturn] public static function notFound(): void {
        self::$ERROR = 'Erreur 404: Page non trouvée.';
        self::redirect('/error', 404, [
            'msg' => 'La pas demandée n\'existe pas.'
        ]);
    }


}