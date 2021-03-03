<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\LoggedInMiddleware;
use app\core\views\builder\SingleLayoutYieldableViewBuilder;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new LoggedInMiddleware(['profile']));
    }

    public function profile(): string
    {
        $user = Application::$app->user;
        $view = (new SingleLayoutYieldableViewBuilder())->get("profile", [
            'email' => $user->email,
            'reflink' => "/r?code=".$user->referral_code,
            'points' => $user->points
        ]);
        return $view->getBuffer();
    }

}