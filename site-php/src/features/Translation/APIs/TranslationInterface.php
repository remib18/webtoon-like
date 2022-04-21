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
     * @param string $text Texte à traduire
     * @param Language $source Langue d'origine
     * @param Language $target Langue vers laquelle traduire
     *
     * @return string Traduction
     */
    public static function translate(string $text, Language $source, Language $target): string;

    /**
     * Traduit plusieurs textes issus du même langage.
     *
     * @param string[] $texts Liste des textes à traduire
     * @param Language $source Langue d'origine
     * @param Language $target Langue vers laquelle traduire
     *
     * @return array<string> Traductions (l'ordre est conservé)
     */
    public static function translateMany(array $texts, Language $source, Language $target): array;

}