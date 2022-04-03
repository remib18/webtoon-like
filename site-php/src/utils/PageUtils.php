<?php

namespace WebtoonLikeSitePhp\utils;

require_once 'UriUtils.php';

const SCRIPTS_PAGE_TYPE = [
    'all' => ['search'],
    'import' => ['importFormController']
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
     * Retourne la page demandée
     *
     * @todo Mini-routeur @gabey
     * 
     * @return string
     */
    public function getPage(): string {
        return '';
    }
    
}