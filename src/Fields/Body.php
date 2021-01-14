<?php

namespace amirgonvt\Press\Fields;

use amirgonvt\Press\MarkdownParser;

class Body
{
    public static function process($type, $value)
    {
        return [
            $type => MarkdownParser::parse($value)
        ];
    }
}