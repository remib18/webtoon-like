<?php

namespace WebtoonLike\Site\features\Translation\APIs;

use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\features\Translation\Result\Bloc;

interface TranslationInterface
{
    // TODO: Remplacer string $text by Block $block

    /**
     * Traduit un texte
     *
     * @param Bloc $bloc Bloc à traduire
     * @param Language $source Langue d'origine
     * @param Language $target Langue vers laquelle traduire
     *
     * @return string Traduction
     */
    public static function translate(Bloc $bloc, Language $source, Language $target): string;

    /**
     * Traduit plusieurs textes issus du même langage.
     *
     * @param Bloc[] $blocs Liste des blocs à traduire
     * @param Language $source Langue d'origine
     * @param Language $target Langue vers laquelle traduire
     *
     * @return array<string> Traductions (l'ordre est conservé)
     */
    public static function translateMany(array $blocs, Language $source, Language $target): array;

}