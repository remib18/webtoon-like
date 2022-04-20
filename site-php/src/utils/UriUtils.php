<?php

namespace WebtoonLike\Site\utils;

use JetBrains\PhpStorm\ArrayShape;

class UriUtils
{
    private string $pageType;

    /** @var array<string, mixed> Liste des options */
    private array $options = [];

    private static ?UriUtils $instance = null;

    private function __construct() {
        $this->analyseUri();
    }

    private static function getInstance(): UriUtils {
        if (is_null(self::$instance)) {
            self::$instance = new UriUtils();
        }
        return self::$instance;
    }

    /**
     * Initialise les valeurs obtenables à partir de l'URI.
     *
     * @return void
     */
    private function analyseUri(): void {
        $re = '/^(\/(?:home|webtoons|index\.php|import|proposition|report|webtoon|error|@\w+)?)(?:[?\/]([\w\-\/=&]*))?$/';
        preg_match_all($re, $_SERVER['REQUEST_URI'], $matches);
        [$_, $pageType, $rawOptions] = $matches;    // Répartition du résultat

        // Vérification de l'existence du résultat
        if ($_ === []) {
            $this->pageType = 'error';
            $this->options['code'] = 404;
            $this->options['message'] = 'La page que vous essayez d\'obtenir n\'existe pas...';
            return;
        }

        // Obtention du type de page
        $this->pageType = match ($pageType[0]) {
            '/', '/home', '/webtoons', '/index.php' => 'home',
            default => substr($pageType[0], 1),
        };


        // Obtention d'un tableau des paramètres
        if ($rawOptions[0] !== '') {
            $options = mb_split('&', $rawOptions[0]);
            foreach ($options as $option) {
                [$key, $value] = mb_split('=', $option);
                $this->options[$key] = $value;
            }
        }
    }

    public static function buildUriGetParamsFromArray(array $array): string {
        if (sizeof($array) < 1) return '';
        $res = '';
        foreach ($array as $key => $value) {
            $res .= '&' . urlencode($key) . '=' . urlencode($value);
        }
        return '?' . substr($res, 1);
    }


    /**
     * Obtention du type de la page
     *
     * @return string
     */
    public static function getPageType(): string {
        return self::getInstance()->pageType;
    }

    /**
     * Obtention des paramètres sous forme de tableau
     *
     * @todo : Add GET / POST parameters
     * @return array<string, mixed>
     */
    public static function getArrayOptions(): array {
        return self::getInstance()->options;
    }

    public static function isHandler(): bool {
        return str_starts_with(self::getInstance()->pageType, '@');
    }

    /**
     * Détermine le protocole d'une uri et la ressource demandée.
     *
     * @param string $uri
     * @return array
     */
    #[ArrayShape([
        'protocol' => 'string',
        'ressource' => 'string'
    ])]
    public static function uriProtocol(string $uri): array {
        [$protocol, $ressource] = mb_split('://', $uri);
        return [
            'protocol' => $protocol,
            'ressource' => $ressource
        ];
    }
}