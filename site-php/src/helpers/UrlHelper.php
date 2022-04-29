<?php

namespace WebtoonLike\Site\helpers;

class UrlHelper
{
    public static function buildUrl(string $uri, array $parameter): string {
        $req = $uri . '?';
        foreach ($parameter as $key => $value) {
            $req .= $key . '=' . urlencode($value) . '&';
        }

        return substr($req, 0, -1);
    }
}