<?php

namespace WebtoonLikeSitePhp\utils;

require_once 'UriUtils.php';

const SCRIPTS_PAGE_TYPE = [
    'all' => ['search'],
    'import' => ['importFormController']
];

const NAVIGUATION = [
    'home' => [
        'target' => '/',
        'icon' => '',
        'label' => 'Tous les webtoons',
        'tooltip' => '',
        //'access' => 'everyone' // TODO[user-system]
    ],
    'import' => [
        'target' => '/import?type=webtoon',
        'icon' => '<svg class="icon" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                       <path d="M20 22.9869H24.75C28.1875 22.9869 31 21.1612 31 17.7619C31 14.3625 27.6875 12.67 25 12.5369C24.4444 7.22062 20.5625 3.98688 16 3.98688C11.6875 3.98688 8.91 6.84875 8 9.68687C4.25 10.0431 1 12.4294 1 16.3369C1 20.2444 4.375 22.9869 8.5 22.9869H12" class="stroke" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                       <path d="M16 28.0132V12.9869M20 15.9869L16 11.9869L12 15.9869H20Z" class="stroke" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                   </svg>',
        'label' => 'Importer',
        'tooltip' => 'Importer un webtoon',
        //'access' => 'everyone' // TODO[user-system]
    ]
];

class PageUtils
{
    private string $pageType;

    public function __construct() {
        $uri = new UriUtils();
        $this->pageType = $uri->getPageType();
    }

    /**
     * Retourne le titre de la page
     *
     * @todo : if pageType = webtoon then "WebtoonLike — {webtoon-title}"
     * @return string
     */
    public function getPageTitle(): string {
        return 'WebtoonLike — ' . ucfirst($this->pageType);
    }

    /**
     * Retourne les imports de styles CSS en HTML
     *
     * @return string
     */
    public function getStylesheets(): string {
        $reset = '<link rel="stylesheet" href="/assets/styles/reset.css">';
        $app = '<link rel="stylesheet" href="/assets/styles/app.css">';
        $page = '';
        if (file_exists(dirname(__DIR__, 2) . '/assets/styles/page-' . $this->pageType . '.css')) {
            $page = '<link rel="stylesheet" href="/assets/styles/page-' . $this->pageType . '.css">';
        }
        return $reset . $app . $page;
    }

    /**
     * Retourne les imports de scripts JS en HTML
     *
     * @return string
     */
    public function getScripts(): string {
        $res = '';
        $custom = SCRIPTS_PAGE_TYPE[$this->pageType] ?? [];
        $scriptsName = [...SCRIPTS_PAGE_TYPE['all'], ...$custom];
        foreach ($scriptsName as $name) {
            if (file_exists(dirname(__DIR__, 2) . '/assets/scripts/' . $name . '.js')) {
                $res .= '<script src="/assets/scripts/' . $name . '.js" defer type="module"></script>';
            }
        }
        return $res;
    }

    /**
     * Affiche la page demandée
     */
    public function router(): void {
        $path = dirname(__DIR__) . '/pages/' . $this->pageType . '.php';
        if (!file_exists($path)) {
            header(
                'Location: /error?code=500&msg='
                . urlencode('Un problème est survenu lors de la création de la page, le template n\'existe pas.')
            );
            die;
        }
        require $path;
    }

    /**
     * Retourne le logo du site
     *
     * @return string
     */
    public function getLogo(): string {
        $logo = '<h1 class="logo">WebtoonLike</h1>';
        if ($this->pageType === 'home') {
            return $logo;
        }
        return '<a href="/">' . $logo . '</a>';
    }

    /**
     * Retourne la navigation du site
     *
     * @return string
     */
    public function getNaviguation(): string {
        $res = '';
        foreach (NAVIGUATION as $page => $item) {
            $isCurrent = $this->pageType === $page;
            $res .= '<li data-tooltip="' . '">';
            $res .= $isCurrent ? '' : '<a href="' . $item['target'] . '">';
            $res .= $item['icon'];
            $res .= '<span>' . $item['label'] . '</span>';
            $res .= $isCurrent ? '' : '</a>';
            $res .= '</li>';
        }
        return $res;
    }
    
}