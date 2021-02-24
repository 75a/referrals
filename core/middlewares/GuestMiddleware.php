<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exception\NotGuestException;

class GuestMiddleware extends BaseMiddleware
{
    public array $actions = [];

    public function __construct( array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute(): void
    {
        if (!Application::isGuest()){
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new NotGuestException();
            }
        }
    }
}