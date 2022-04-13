<?php

namespace WebtoonLike\Site\features\Translation\APIs;

use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\exceptions\InvalidRequestException;
use WebtoonLike\Site\exceptions\InvalidApiKeyException;
use WebtoonLike\Site\exceptions\TranslationErrorException;
use WebtoonLike\Site\exceptions\SlowDownException;
use WebtoonLike\Site\helpers\curlHelper;

class LibreTranslateTranslation implements TranslationInterface
{
    private static array $mirrors = ['https://libretranslate.de/',
    'https://translate.argosopentech.com/',
    'https://libretranslate.pussthecat.org/',
    'https://translate.fortytwo-it.com/'
    ];

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
     * @param string $text Texte à traduire
     * @param Language $source Langue d'origine
     * @param Language $target Langue vers laquelle traduire
     * @return string Traduction
     *
     * @throws InvalidApiKeyException
     * @throws InvalidRequestException
     * @throws SlowDownException
     * @throws TranslationErrorException
     */
    public static function translate(string $text, Language $source, Language $target): string
    {
        $requests = self::preparePostRequest($text, $source, $target, 'translate');

        foreach ($requests as $data)
        {
            $response = curlHelper::httpPost($data);
            $code = $response['httpCode'];
            if($code == 200)
            {
                return $response['response'];
            }
            else if( $code == 403 )
            {
                throw new InvalidApiKeyException('Invalid Api Key For ' . $data['url']);
            }
            else
            {
                $error = $response['response']['error'];
                if( $code == 500 )
                {
                    // TO-DO: verify the language was available.
                    // Return if it was.
                    throw new TranslationErrorException($error);
                }
                else
                {
                    if( $code == 400 )
                    {
                        throw new InvalidRequestException($error);
                    }
                    else if( $code == 429 )
                    {
                        throw new SlowDownException($error);
                    }
                    return '';
                }
            }
        }
        throw new NoApiAvailableException('No Translation Api Was Up');
        return '';
    }

    /**
     * @inheritDoc
     */
    public static function translateMany(array $texts, Language $source, Language $target): array
    {
        $response = [];
        foreach ($texts as $text) {
            try
            {
                $response[] = self::translate($text, $source, $target);
            } catch (InvalidApiKeyException|TranslationErrorException|SlowDownException|InvalidRequestException $e) {}
        }
        return $response;
    }
}