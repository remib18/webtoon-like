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
    ]
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
