<?php

namespace app\core\flash;

use app\core\Application;

class SuccessFlash extends Flash
{
    protected const TYPE_NAME = "Success";
    protected const STYLE_CLASS_NAME = "flash-success";
}