<?php

namespace WebtoonLike\Site\utils\DataTesting;

enum Regex : string {
    case username = '^[a-zA-Z0-9_\-]';
}