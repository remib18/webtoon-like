<?php

namespace WebtoonLike\Site\features\Translation\APIs;

use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\exceptions;
use WebtoonLike\Site\helpers\curlHelper;

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
                'source' => $source,
                'target' => $target,
                'format' => 'text'
            ]
        ];
        return $request;
    }

    /**
     * @inheritDoc
     */
    public static function translate(Language $text, Language $source, Language $target): string
    {
        $data = self::preparePostRequest($text, $source, $target, 'translate');
        $response = curlHelper::httpPost($data);

        $code = $response['httpCode'];
        if($code == 200)
        {
            return $response['response'];
        }
        else
        {
            $error = $response['response']['error'];
            if( $code == 400 )
            {
                throw new InvalidRequestException($error);
            }
            else if( $code == 403 )
            {
                throw new InvalidApiKeyException($error);
            }
            else if( $code == 429 )
            {
                throw new SlowDownException($error);
            }
            else if( $code == 500 )
            {
                throw new TranslationErrorException($error);
            }
            return '';
        }

        return $response['response'];
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