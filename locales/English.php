<?php

namespace app\locales;

use app\core\Language;

class English extends Language
{
    public static array $texts;

    public static function getTexts(): array
    {
        return [
            "Status 0" => "Inactive",
            "Status 1" => "Active",

        ];
    }
}