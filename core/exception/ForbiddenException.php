<?php

namespace app\core\exception;

use app\core\Application;
use Throwable;

class ForbiddenException extends \Exception
{
    protected $code = 403;
    protected $message = "You dont have permission to access this page";
}