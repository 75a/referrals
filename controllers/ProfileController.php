<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\LoggedInMiddleware;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new LoggedInMiddleware(['profile']));
    }

    public function profile()
    {
        $user = Application::$app->user;
        return $this->render('profile', [
            'email' => $user->email,
            'fullname' => $user->getDisplayName(),
            'reflink' => $user->referral_code,
            'points' => $user->points
        ]);
    }

}