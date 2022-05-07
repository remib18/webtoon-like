<?php

namespace WebtoonLike\Site\routine;

use WebtoonLike\Site\controller\LanguageController;
use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\features\Translation\APIs\AzureTranslation;

class DatabaseLoader {
    /**
     * Remplissage de la table langage en BDD à partir de l'API azure.
     *
     * @return void
     */
    public static function loadLanguageFromAzure(): void {
        $languages = AzureTranslation::availibleLanguageList();

        if(!$languages) return;

        foreach($languages as $identifier => $content) {

            $language = LanguageController::getById($identifier);
            if(is_null($language)) {
                $language = new Language($identifier, $content['name'], false);
                LanguageController::create($language);
            }
        }
    }
}




