<?php

namespace WebtoonLike\Site\helpers;

use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use WebtoonLike\Site\Settings;

class CurlHelper {

    /**
     * Retourne la réponse d'une requête GET.
     *
     * @param array $params
     *
     * @return array Code réponse HTTP et contenu.
     *
     * @throws InvalidArgumentException
     */
    #[ArrayShape(['httpCode' => "mixed", 'response' => "mixed"])]
    public static function httpGet(array $params): array
    {
        if (!isset($params['url'])) {
            throw new InvalidArgumentException('Missing params url key.');
        }
        $url = $params['url'];
        $curlSession = curl_init($url);
            curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
            // if a userAgent is specified, use it.
            if(isset($params['userAgent']))
            {
                curl_setopt($curlSession, CURLOPT_HTTPHEADER, $params['userAgent']);
            }

            // use while testing
            if( Settings::get('production') == false ) {
                curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, false);
            }

            $response = curl_exec($curlSession);
            $decodedResponse = json_decode( $response, true );
            $responseCode = curl_getinfo($curlSession, CURLINFO_HTTP_CODE);
        curl_close($curlSession);

        return ['httpCode' => $responseCode, 'response' => $decodedResponse];
    }

    /**
     * Retourne la réponse d'une requête POST
     *
     * @param array $params
     * @return array Code réponse HTTP et contenu.
     */
    #[ArrayShape(['httpCode' => "mixed", 'response' => "mixed"])]
    public static function httpPost(array $params): array
    {
        if (!isset($params['url'])) {
            throw new InvalidArgumentException('Missing params url key.');
        }
        if (!isset($params['query'])) {
            throw new InvalidArgumentException('Missing params query key.');
        }
        $jsonData = json_encode($params['query']);
        $curlSession = curl_init($params['url']);
            curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curlSession, CURLOPT_POST, true);
            curl_setopt($curlSession, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($curlSession, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($jsonData))
            );

            // use while testing
            if( Settings::get('production') == false ) {
                curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, false);
            }

            $response = curl_exec($curlSession);
            $decodedResponse = json_decode( $response, true );
            $responseCode = curl_getinfo($curlSession, CURLINFO_HTTP_CODE);
        curl_close($curlSession);

        return ['httpCode' => $responseCode, 'response' => $decodedResponse];
    }
}