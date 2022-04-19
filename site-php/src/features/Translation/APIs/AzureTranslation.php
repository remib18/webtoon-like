<?php

namespace WebtoonLike\Site\features\Translation\APIs;

use JetBrains\PhpStorm\ArrayShape;
use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\exceptions\TranslationException;
use WebtoonLike\Site\helpers\CurlHelper;
use WebtoonLike\Site\Settings;

class AzureTranslation implements TranslationInterface
{

    /**
     * Prepare l'URI pour utiliser l'APi d'azure sur l'end-point: /translate
     *
     * @return String
     */
    public static function prepareURL(Language $source, Language $target): string
    {
        $uri = 'https://api.cognitive.microsofttranslator.com/translate';
        $options = [
            'api-version' => '3.0',
            'from' => $source->getIdentifier(),
            'to' => $target->getIdentifier()
        ];

        $req = $uri . '?';
        foreach ($options as $key => $value) {
            $req .= $key . '=' . $value . '&';
        }

        return substr($req, 0, -1);
    }

    /**
     * if run on windows: uses com_create_guid
     * Otherwise, a GUID is generated.
     *
     * @return String
     */
    public static function createGUID(): string {
        if (function_exists('com_create_guid') === true)
        {
            # dans {} par convention
            return trim(com_create_guid(), '{}');
        }
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
            mt_rand(0, 65535), mt_rand(0, 65535),
            mt_rand(0, 65535), mt_rand(16384, 20479),
            mt_rand(32768, 49151), mt_rand(0, 65535),
            mt_rand(0, 65535), mt_rand(0, 65535)
        );
    }

    /**
     * Renvoie un dictionnaire contenant les différentes elements
     * nécessaire pour envoyer une requête vers l'api AZURE.
     *
     * @return array
     */
    #[ArrayShape(['url' => "string", 'query' => "\string[][]"])]
    public static function buildRequest(string $text, Language $source, Language $target): array {

        $keyHeader = 'Ocp-Apim-Subscription-Key: ' . Settings::get('AZURE_API_KEY');
        $guidHeader = 'X-ClientTraceId: '. self::createGUID();

        return [
            'url' => self::prepareURL($source, $target),
            'query' =>  [['Text' => $text]]
        ];
    }

    /**
     * Renvoie les headers nécessaire pour envoyer une requête vers l'api AZURE.
     *
     * @return array
     */
    public static function buildHeader(): array {
        $keyHeader = 'Ocp-Apim-Subscription-Key: ' . Settings::get('AZURE_API_KEY');
        $guidHeader = 'X-ClientTraceId: '. self::createGUID();
        $location = 'Ocp-Apim-Subscription-Region: '. Settings::get('AZURE_API_LOCATION');

        return [$keyHeader, $guidHeader, $location];
    }

    /**
     * Traduit les textes.
     *
     * @param string $text
     * @param Language $source
     * @param Language $target
     * @return String
     * @throws TranslationException
     */
    public static function translate(string $text, Language $source, Language $target): string
    {
        $requests = self::buildRequest($text, $source, $target);
        $headers = self::buildHeader();
        $response = curlHelper::httpPost($requests, $headers);

        $code = $response['httpCode'];

        if($code === 200) {
            return $response['response'][0]['translations'][0]['text'];
        }

        $errorCode = $response['response']["error"]["code"];
        $errormsg = $response['response']["error"]["message"];
        if($code === 400) {
            throw new UnsupportedLanguageException($errorCode . ' :' .  $errormsg);
        }

        throw new TranslationException($errorCode . ' :' .  $errormsg);

        return '';
    }

    /**
     * @inheritDoc
     */
    public static function translateMany(array $texts, Language $source, Language $target): array
    {
        return [];
    }
}