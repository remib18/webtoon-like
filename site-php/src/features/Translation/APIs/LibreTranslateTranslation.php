<?php

namespace WebtoonLike\Site\features\Translation\APIs;

use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\exceptions\TranslationException;
use WebtoonLike\Site\helpers\curlHelper;

class LibreTranslateTranslation implements TranslationInterface
{
    private static array $mirrors = [
        'https://libretranslate.de/',
        'https://translate.argosopentech.com/',
        'https://libretranslate.pussthecat.org/',
        'https://translate.fortytwo-it.com/'
    ];

    /**
     * Prepare POST requests.
     *
     * @param string $text
     * @param string $source
     * @param string $target
     * @param string $endpoint
     * @return array
     */
    public static function preparePostRequest(string $text, string $source, string $target, string $endpoint): array
    {
        $request = [];
        foreach (self::$mirrors as $mirror)
        {
            $request[] = [
                'url' => $mirror . $endpoint,
                'query' => [
                    'q' => $text,
                    'source' => $source,
                    'target' => $target,
                    'format' => 'text'
                ]
            ];
        }

        return $request;
    }

    /**
     * Traduit un texte
     *
     * @param string   $text
     * @param Language $source Langue d'origine
     * @param Language $target Langue vers laquelle traduire
     *
     * @return string Traduction
     *
     * @throws TranslationException
     */
    public static function translate(string $text, Language $source, Language $target): string
    {

        $requests = self::preparePostRequest($text, $source->getIdentifier(), $target->getIdentifier(), 'translate');

        foreach ($requests as $data) {
            $response = curlHelper::httpPost($data);
            $code = $response['httpCode'];

            if($code === 200) {
                return $response['response']['translatedText'];
            }
        }
        throw new TranslationException('No Translation Api Was Up.');
    }

    /**
     * @inheritDoc
     */
    public static function translateMany(array $texts, Language $source, Language $target): array
    {
        $response = [];
        foreach ($texts as $text) {
            $response[] = self::translate($text, $source, $target);
        }
        return $response;
    }
}