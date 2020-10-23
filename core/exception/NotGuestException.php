<?php


namespace app\core\exception;


class NotGuestException extends \Exception
{
    protected $code = 403;
    protected $message = 'This page is available only for the guest users';
}