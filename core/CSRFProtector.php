<?php


namespace app\core;


class CSRFProtector
{
    const CSRF_KEY = "csrfToken";
    const CSRF_KEY_LENGTH = 8;

    public static function getToken(): string
    {
        return Application::$app->session->get(self::CSRF_KEY);
    }

    public static function setTokenIfNotExist(): void
    {
        if (!self::getToken()){
            Application::$app->session->set(self::CSRF_KEY, Utils::getRandomString(self::CSRF_KEY_LENGTH));
        }
    }

    public static function removeToken(): void
    {
        Application::$app->session->remove(self::CSRF_KEY);
    }
}