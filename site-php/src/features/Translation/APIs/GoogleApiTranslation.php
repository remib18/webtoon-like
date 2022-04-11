<?php

namespace WebtoonLike\Site\features\Translation\APIs;

use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\exceptions\InvalidRequestException;
use WebtoonLike\Site\exceptions\InvalidApiKeyException;
use WebtoonLike\Site\exceptions\TranslationErrorException;
use WebtoonLike\Site\Settings;

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
            'key' => Settings::get('googleTranslateApi'),
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
     * Traduit un texte
     *
     * @param string $text Texte à traduire
     * @param Language $source Langue d'origine
     * @param Language $target Langue vers laquelle traduire
     *
     * @return string Traduction
     *
     *
     * @throws InvalidRequestException
     * @throws InvalidApiKeyException
     * @throws TranslationErrorException
     */
    public static function translate(string $text, Language $source, Language $target): string
    {
        $url = self::prepareURL($text, $source, $target);
        $response = curlHelper::httpGet($url);

        $code = $response['httpCode'];
        $decodedResponse = $response['response']['decodedResponse'];
        if($code == 200)
        {
            return $decodedResponse['data']['translations'][0]['translatedText'];
        }
        else
        {
            $error = $decodedResponse['error']['errors'][0]['message'];
            if( $code == 400 )
            {
                throw new InvalidRequestException($error);
            }
            else if( $code == 403 )
            {
                throw new InvalidApiKeyException($error);
            }
            else if( $code == 500 )
            {
                throw new TranslationErrorException($error);
            }
            return '';
        }

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
            }
            catch (InvalidApiKeyException|TranslationErrorException|InvalidRequestException $e) {}
        }
        return $response;
    }
}