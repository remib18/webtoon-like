<?php

namespace WebtoonLike\Site\pageManager;

class deleteAccountManager {

    /**
     * Génère les paragraphes avec les erreurs pour le formulaire de deletion.
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
