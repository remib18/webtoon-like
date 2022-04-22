<?php

namespace WebtoonLike\Site\core;

enum AccessLevel
{
    case Logged;
    case Unlogged;
    case Everyone;

}