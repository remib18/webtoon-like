<?php

namespace WebtoonLike\Site\pageManager;

class RegisterManager {

    /**
     * Génère les paragraphes avec les erreurs pour le formulaire d'enregistrement.
     *
     * @return string
     */
    public static function getErrors(): string {

        $res = '';

        if(empty($_GET)) return '';

        foreach ( $_GET as $key => $error ) {
            if(str_contains($key, 'error')) {
                $res .= '<p>' . $error . '</p>';
            }
        }

        return "<div id='erreur-box'>" . $res . "</div>";
    }

}
