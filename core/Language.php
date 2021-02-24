<?php

namespace app\core;

abstract class Language
{
    public static function getTexts(): array
    {
        return [];
    }

    public static function translate(string $key): string
    {
        $textToReturn = $key;
        $allTexts = static::getTexts();
        if (array_key_exists($key, $allTexts)) {
            $textToReturn = $allTexts[$key];
        }
        return $textToReturn;
    }
}