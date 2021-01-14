<?php

namespace amirgonvt\Press\Fields;

use amirgonvt\Press\MarkdownParser;

class Body extends FieldContract
{
    public static function process($type, $value,  $data)
    {
        return [
            $type => MarkdownParser::parse($value)
        ];
    }
}