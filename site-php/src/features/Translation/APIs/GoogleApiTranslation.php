<?php

namespace WebtoonLike\Site\features\Translation\APIs;

use WebtoonLike\Site\entities\Language;
use function WebtoonLike\Site\getSettings;


class GoogleApiTranslation implements TranslationInterface
{
    /**
    * @inheritDoc
    */
    public static function buildRequest(string $text, Language $source, Language $target): array 
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
        $response = [
            'method' => 'GET',
            'url' => substr($req, 0, -1)
        ];

        return $response;
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