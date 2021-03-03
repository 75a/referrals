<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exception\ReflinkException;
use app\core\handlers\RefclickHandler;

class ValidReflinkMiddleware extends BaseMiddleware
{
    public array $actions = [];

    public function __construct( array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute(): void
    {
        $refclickHandler = new RefclickHandler(Application::$app->request->getBody()['code']);
        if (!($refclickHandler->isValidRefclick() && $refclickHandler->registerNewClick())) {
            throw new ReflinkException();
        }
    }
}