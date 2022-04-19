<?php

namespace WebtoonLike\Site\features\Translation\APIs;

use WebtoonLike\Site\entities\Language;

class AzureTranslation implements TranslationInterface
{

    /**
     * @inheritDoc
     */
    public static function translate(string $text, Language $source, Language $target): string
    {
        // TODO: Implement translate() method.
    }

    /**
     * @inheritDoc
     */
    public static function translateMany(array $texts, Language $source, Language $target): array
    {
        // TODO: Implement translateMany() method.
    }
}