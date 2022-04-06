<?php

namespace WebtoonLike\Site\exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

class AlreadyExistingRessourceException extends \Exception
{

    #[Pure] public function __construct(string $message = "La ressource existe déjà.", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}