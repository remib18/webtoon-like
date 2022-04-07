<?php

namespace WebtoonLike\Site\features\Translation\APIs;

use WebtoonLike\Site\entities\Language;

/**
 *
 */
class LibreTranslateTranslation implements TranslationInterface
{

    /**
     * Prepare POST requests.
     *
     * @param string $text
     * @param Language $source
     * @param Language $target
     * @param string $endpoint
     * @return array
     */
    public static function preparePostRequest(string $text, Language $source, Language $target, string $endpoint): array
    {
        $request = [
            'url' => 'https://libretranslate.com/' . $endpoint,
            'query' => [
                'q' => $text,
                '$source' => $source,
                '$target' => $target,
                'format' => 'text'
            ]
        ];
        return $request;
    }

    /**
     * @inheritDoc
     */
    public static function translate(string $text, Language $source, Language $target): string
    {

    }

    /**
     * @inheritDoc
     */
    public static function translateMany(array $texts, Language $source, Language $target): array
    {
        // TODO: Implement translateMany() method.
    }
}