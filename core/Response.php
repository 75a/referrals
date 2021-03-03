<?php

namespace app\core;

class Response
{
    public string $message = "";

    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function getStatusCode(): int
    {
        return http_response_code();
    }

    public function redirect(string $url): void
    {
        header('Location: '.$url);
    }
}