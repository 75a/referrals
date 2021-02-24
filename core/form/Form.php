<?php

namespace app\core\form;

use app\core\CSRFProtector;
use app\core\Model;

class Form
{
    public static function begin($action, $method): Form
    {
        echo sprintf('<form action="%s" method ="%s">', $action, $method);
        return new Form();
    }

    public function getCSRFField(string $token): string
    {
        return sprintf('<input type="hidden" name="%s" value="%s">', CSRFProtector::CSRF_KEY, $token);
    }

    public static function end (): void
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute): InputField
    {
        return new InputField($model, $attribute);
    }
}