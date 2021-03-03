<?php

namespace app\core;

use app\core\flash\Flash;
use app\core\flash\SuccessFlash;

class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();
        if (ISSET($_SESSION[self::FLASH_KEY])) {
            $_SESSION[self::FLASH_KEY]->setFlashToBeRemoved();
        }
    }

    public function __destruct()
    {
        echo(http_response_code());
        if (ISSET($_SESSION[self::FLASH_KEY]) && $_SESSION[self::FLASH_KEY]->shouldBeRemoved()) {
            $_SESSION[self::FLASH_KEY] = null;
        }
    }

    public function setFlash(Flash $flash): void
    {
        $_SESSION[self::FLASH_KEY] = $flash;
    }

    public function isFlashSet(): bool
    {
        return ISSET($_SESSION[self::FLASH_KEY]);
    }

    public function getFlash(): ?Flash
    {
        return $_SESSION[self::FLASH_KEY] ?? null;
    }

    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get($key): string
    {
        return $_SESSION[$key] ?? "";
    }

    public function remove($key): void
    {
        unset($_SESSION[$key]);
    }

}