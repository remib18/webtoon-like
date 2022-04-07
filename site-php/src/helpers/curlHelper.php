<?php

namespace WebtoonLike\Site\helpers;

ini_set('display_errors', 1);
error_reporting(E_ALL);

class curlHelper {

    /**
     * Retourne la reponse d'une requete GET.
     *
     * @param array $params
     * @return array : code reponse HTTP et contenu.
     */
    public static function httpGet(array $params): array
    {
        $url = $params['url'];
        $curlSession = curl_init($url);
            curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
            // if a userAgent is specified, use it.
            if(isset($params['userAgent']))
            {
                curl_setopt($curlSession, CURLOPT_HTTPHEADER, $params['userAgent']);
            }

            // use while testing
            // curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, false);

            $response = curl_exec($curlSession);
            $decodedResponse = json_decode( $response, true );
            $responseCode = curl_getinfo($curlSession, CURLINFO_HTTP_CODE);
        curl_close($curlSession);

        return ['httpCode' => $responseCode, 'response' => $decodedResponse];
    }

    /**
     * Retourne la reponse d'une requete POST
     *
     * @param array $params
     * @return array : code reponse HTTP et contenu.
     */
    public static function httpPost(array $params): array {

        $jsonData = json_encode($params['query']);


        $curlSession = curl_init($params['url']);
            curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curlSession, CURLOPT_POST, true);
            curl_setopt($curlSession, CURLOPT_POSTFIELDS, $jsonData);

            // use while testing
            // curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curlSession, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($jsonData))
            );

            $response = curl_exec($curlSession);
            $decodedResponse = json_decode( $response, true );
            $responseCode = curl_getinfo($curlSession, CURLINFO_HTTP_CODE);
        curl_close($curlSession);

        return ['httpCode' => $responseCode, 'response' => $decodedResponse];
    }
}