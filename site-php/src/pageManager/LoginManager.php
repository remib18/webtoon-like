<?php

namespace WebtoonLike\Site\pageManager;

class LoginManager {

    /**
     * Génère les paragraphes avec les erreurs pour le formulaire de login.
     *
     * @return string
     */
    public static function getErrors(): string {

        $res = '';

        if(!isset($_GET)) return '';

        foreach ( $_GET as $key => $error ) {
            if(str_contains($key, 'error')) {
                $res .= '<p>' . $error . '</p>';
            }
        }

        return $res;
    }

}