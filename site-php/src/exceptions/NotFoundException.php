<?php

namespace WebtoonLike\Site\exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class NotFoundException extends Exception
{

    #[Pure] public function __construct(string $message = "Ressource not found.", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}