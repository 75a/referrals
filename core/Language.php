<?php

namespace app\core;

abstract class Language
{
    protected const LANGUAGE_CODE = "";
    protected const LANGUAGE_TRANSLATIONS = [];

    public function getLanguageCodeForHTMLDocument(): string
    {
        return static::LANGUAGE_CODE;
    }

    public static function getTexts(): array
    {
        return static::LANGUAGE_TRANSLATIONS;
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

    public static function language(): Language
    {
        return new static;
    }
}