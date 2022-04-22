<?php

namespace WebtoonLike\Site\core;

enum AccessLevel: int
{
    case everyone = 0;
    case authenticated = 1;

}