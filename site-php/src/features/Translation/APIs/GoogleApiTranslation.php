<?php

namespace WebtoonLike\Site\features\Translation\APIs;

use WebtoonLike\Site\entities\Language;
use function WebtoonLike\Site\getSettings;


class GoogleApiTranslation implements TranslationInterface
{
    /**
     * Generate URL for the translate method.
     *
     * @param string $text
     * @param Language $source
     * @param Language $target
     * @return url
     */
    public static function prepareURL(string $text, Language $source, Language $target): string
    {
        $uri = 'https://www.googleapis.com/language/translate/v2';
        $options = [
            'key' => getSettings()['googleTranslateApi'],
            'q' => rawurlencode($text),
            'source' => $source,
            'target' => $target
        ];
        $req = $uri . '?';
        foreach ($options as $key => $value) {
            $req .= $key . '=' . $value . '&';
        }

        return substr($req, 0, -1);
    }

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