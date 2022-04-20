<?php

namespace WebtoonLike\Site\core;

use WebtoonLike\Site\exceptions\NotFoundException;

class TemplateEngine
{

    /**
     * Charge un template
     *
     * @param string $template Chemin du fichier HTML
     * @param array  $data Paramètres à modifier
     *
     * @return string HTML
     *
     * @throws NotFoundException En cas de fichier introuvable
     */
    public static function load(string $template, array $data): string {
        return '';
    }

}