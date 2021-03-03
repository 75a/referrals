<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\exception\ReflinkException;
use app\core\flash\ErrorFlash;
use app\core\flash\SuccessFlash;
use app\core\flash\WarningFlash;
use app\core\handlers\RefclickHandler;
use app\core\middlewares\LoggedInMiddleware;
use app\core\middlewares\ValidReflinkMiddleware;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new ValidReflinkMiddleware(['refclick']));
    }

    public function refclick(): void
    {
        Application::$app->session->setFlash(
            new SuccessFlash("You just gave someone points by clicking this referral link")
        );
        Application::$app->response->redirect('/');
    }

}