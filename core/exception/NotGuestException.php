<?php

namespace app\core\exception;

use app\core\Application;
use Throwable;

class NotGuestException extends \Exception
{
    protected $code = 403;
    protected $message = "This page is available only for the guest users";
}