<?php

namespace WebtoonLike\Site\pageManager;

class ChangePasswordManager {

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

        if(empty($res)) return '';
        return "<div id='erreur-box'>" . $res . "</div>";
    }

    public static function getMessages(): string {

        $res = '';
        if(empty($_GET)) return '';

        foreach ( $_GET as $key => $msg ) {
            if(str_contains($key, 'msg')) {
                $res .= '<p>' . $msg . '</p>';
            }
        }

        if(empty($res)) return '';
        return "<div id='msg-box' class='success'>" . $res . "</div>";
    }

}
