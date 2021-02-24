<?php

namespace app\core;

class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage){
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY]  = $flashMessages;
    }

    public function __destruct()
    {
        $this->removeFlashMessages();
    }

    public function setFlash($key, $message): void
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlash ($key): string
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? "";
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

    private function removeFlashMessages(): void
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => $flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

}