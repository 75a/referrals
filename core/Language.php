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
        $textToReturn = "";
        $allTexts = static::getTexts();
        $isKey = array_key_exists($key, $allTexts);

        if ($isKey) {
            $textToReturn = $allTexts[$key];
        }
        return $textToReturn;
    }




}