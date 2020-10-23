<?php

namespace app\locales;

use app\core\Language;

class Polish extends Language
{
    public static array $texts;

    public static function getTexts(): array
    {
        return [
            "Language" => "Język"
        ];
    }
}