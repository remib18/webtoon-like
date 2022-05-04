<?php

namespace WebtoonLike\Site\utils;

use WebtoonLike\Site\core\Authentication;
use WebtoonLike\Site\core\AccessLevel;

require_once 'UriUtils.php';

const SCRIPTS_PAGE_TYPE = [
    'all' => ['search'],
    'import' => ['importFormController']
];

const PAGES = [
    'home' => ['accessLevel' => AccessLevel::everyone],
    'error' => ['accessLevel' => AccessLevel::everyone],
    'webtoon' => ['accessLevel' => AccessLevel::everyone],
    '@login' => ['accessLevel' => AccessLevel::everyone],
    '@register' => ['accessLevel' => AccessLevel::everyone],
    'login' => ['accessLevel' => AccessLevel::everyone],
    'register' => ['accessLevel' => AccessLevel::everyone]
];

const NAVIGATION = [
    'home' => [
        'target' => '/',
        'icon' => '',
        'label' => 'Tous les webtoons',
        'tooltip' => '',
        'accessLevel' => AccessLevel::everyone
    ],
    'import' => [
        'target' => '/import?type=webtoon',
        'icon' => '<svg class="icon" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                       <path d="M20 22.9869H24.75C28.1875 22.9869 31 21.1612 31 17.7619C31 14.3625 27.6875 12.67 25 12.5369C24.4444 7.22062 20.5625 3.98688 16 3.98688C11.6875 3.98688 8.91 6.84875 8 9.68687C4.25 10.0431 1 12.4294 1 16.3369C1 20.2444 4.375 22.9869 8.5 22.9869H12" class="stroke" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                       <path d="M16 28.0132V12.9869M20 15.9869L16 11.9869L12 15.9869H20Z" class="stroke" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                   </svg>',
        'label' => 'Importer',
        'tooltip' => 'Importer un webtoon',
        'accessLevel' => AccessLevel::authenticated
    ],
    'login' => [
        'target' => 'login',
        'icon' => '',
        'label' => 'Connexion',
        'tooltip' => 'Se connecter au site web.',
        'accessLevel' => AccessLevel::everyone
    ],
    'logout' => [
        'target' => '@logout',
        'icon' => '',
        'label' => 'Déconnexion',
        'tooltip' => 'Se déconnecter du site web.',
        'accessLevel' => AccessLevel::authenticated
    ],
    'actions' => [
        'target' => 'user',
        'icon' => '<svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 0.5C5.83187 0.5 0 6.33187 0 13.5C0 20.6681 5.83187 26.5 13 26.5C20.1681 26.5 26 20.6681 26 13.5C26 6.33187 20.1681 0.5 13 0.5ZM9.86125 7.80125C10.6531 6.96188 11.7675 6.5 13 6.5C14.2325 6.5 15.3369 6.965 16.1319 7.80875C16.9375 8.66375 17.3294 9.8125 17.2369 11.0475C17.0519 13.5 15.1519 15.5 13 15.5C10.8481 15.5 8.94438 13.5 8.76313 11.0469C8.67125 9.80187 9.0625 8.64938 9.86125 7.80125V7.80125ZM13 24.5C11.5315 24.501 10.0778 24.2071 8.7251 23.6357C7.37236 23.0643 6.14813 22.2271 5.125 21.1737C5.71097 20.3381 6.4576 19.6276 7.32125 19.0837C8.91437 18.0625 10.9306 17.5 13 17.5C15.0694 17.5 17.0856 18.0625 18.6769 19.0837C19.5412 19.6273 20.2885 20.3379 20.875 21.1737C19.852 22.2272 18.6277 23.0645 17.275 23.6359C15.9222 24.2073 14.4685 24.5011 13 24.5V24.5Z" fill="white" fill-opacity="0.8"/>
                   </svg>',
        'label' => '',
        'tooltip' => 'Utilisateur',
        'accessLevel' => AccessLevel::authenticated
    ],
];

class PageUtils
{
    private string $pageType;

    private static ?PageUtils $instance = null;

    private function __construct() {
        $this->pageType = UriUtils::getPageType();
    }

    private static function getInstance(): PageUtils {
        if (is_null(self::$instance)) self::$instance = new PageUtils();
        return self::$instance;
    }

    /**
     * Retourne le niveau minimum pour accéder à la ressource.
     *
     * @return AccessLevel
     */
    public static function getPageAccess(): AccessLevel {
        return PAGES[UriUtils::getPageType()]['accessLevel'] ?? AccessLevel::authenticated;
    }

    /**
     * Retourne le titre de la page
     *
     * @return string
     * @todo : if pageType = webtoon then "WebtoonLike — {webtoon-title}"
     */
    public static function getPageTitle(): string {
        return 'WebtoonLike — ' . ucfirst(self::getInstance()->pageType);
    }

    /**
     * Retourne les imports de styles CSS en HTML
     *
     * @return string
     */
    public static function getStylesheets(): string {
        $reset = '<link rel="stylesheet" href="/assets/styles/reset.css">';
        $app = '<link rel="stylesheet" href="/assets/styles/app.css">';
        $page = '';
        if (file_exists(dirname(__DIR__, 2) . '/assets/styles/page-' . self::getInstance()->pageType . '.css')) {
            $page = '<link rel="stylesheet" href="/assets/styles/page-' . self::getInstance()->pageType . '.css">';
        }
        return $reset . $app . $page;
    }

    /**
     * Retourne les imports de scripts JS en HTML
     *
     * @return string
     */
    public static function getScripts(): string {
        $res = '';
        $custom = SCRIPTS_PAGE_TYPE[self::getInstance()->pageType] ?? [];
        $scriptsName = [...SCRIPTS_PAGE_TYPE['all'], ...$custom];
        foreach ($scriptsName as $name) {
            if (file_exists(dirname(__DIR__, 2) . '/assets/scripts/' . $name . '.js')) {
                $res .= '<script src="/assets/scripts/' . $name . '.js" defer type="module"></script>';
            }
        }
        return $res;
    }

    /**
     * Retourne le logo du site
     *
     * @return string
     */
    public static function getLogo(): string {
        $logo = '<h1 class="logo">WebtoonLike</h1>';
        if (self::getInstance()->pageType === 'home') {
            return $logo;
        }
        return '<a href="/">' . $logo . '</a>';
    }

    /**
     * Retourne la navigation du site
     *
     * @return string
     */
    public static function getNavigation(): string {
        $res = '';
        foreach (NAVIGATION as $page => $item) {
            $isCurrent = self::getInstance()->pageType === $page;

            if(Authentication::hasAccess($item['accessLevel'], true)) {
                $res .= '<li data-tooltip="' . '">';
                $res .= $isCurrent ? '' : '<a href="' . $item['target'] . '">';
                $res .= $item['icon'];
                $res .= '<span>' . $item['label'] . '</span>';
                $res .= $isCurrent ? '' : '</a>';
                $res .= '</li>';
            }
        }
        return $res;
    }

}
