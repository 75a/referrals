<?php

namespace app\core\exception;

use app\core\Application;
use Throwable;

class ReflinkException extends \Exception
{
    protected $code = 400;
    protected $message = "You can't use this reflink";
}