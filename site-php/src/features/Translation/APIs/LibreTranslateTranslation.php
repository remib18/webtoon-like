<?php

namespace WebtoonLike\Site\features\Translation\APIs;

use WebtoonLike\Site\controller\BlockController;
use WebtoonLike\Site\entities\Block;
use WebtoonLike\Site\entities\Language;
use WebtoonLike\Site\exceptions\InvalidApiKeyException;
use WebtoonLike\Site\exceptions\TranslationException;
use WebtoonLike\Site\exceptions\UnsupportedLanguageException;
use WebtoonLike\Site\features\Translation\Result\Bloc;
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
     * @param Bloc     $bloc
     * @param Language $source Langue d'origine
     * @param Language $target Langue vers laquelle traduire
     *
     * @return string Traduction
     *
     * @throws TranslationException
     */
    public static function translate(Bloc $bloc, Language $source, Language $target): string
    {
        $requests = self::preparePostRequest($bloc->getOriginalText(), $source->getIdentifier(), $target->getIdentifier(), 'translate');

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
    public static function translateMany(array $blocs, Language $source, Language $target): array
    {
        $response = [];
        foreach ($blocs as $bloc) {
            $response[] = self::translate($bloc, $source, $target);
        }
        return $response;
    }

    private static function getFromDB(Bloc $bloc, Language $target) {

    }

    private static function saveToDB(Bloc $bloc) {
        
    }
}