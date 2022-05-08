<?php

namespace WebtoonLike\Site\exceptions;

use JetBrains\PhpStorm\Pure;
use \Throwable;

class UnableToLoadImageException extends \Exception
{

    #[Pure] public function __construct(string $message = "Unable to load images.", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}