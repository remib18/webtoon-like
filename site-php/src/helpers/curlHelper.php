<?php

namespace WebtoonLike\Site\helpers;

class curlHelper {

    /**
     * Retourne la reponse d'une requete GET.
     *
     * @param array $params
     * @return array
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

    public static function httpPost(): array {


        return [];
    }
}
