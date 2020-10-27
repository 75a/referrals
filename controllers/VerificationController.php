<?php

namespace app\controllers;
use app\core\Application;
use app\core\Controller;
use app\core\Response;
use app\models\User;

class VerificationController extends Controller
{
    public function verify()
    {
        if (isset($_GET['code'])){
            $foundUser = (new User)->findOne(['verifyCode' => $_GET['code']]);
            if ($foundUser) {
                $foundUser->verify();
                Application::$app->session->setFlash('success',Application::$app
                    ->getText('Your account has been activated!'));
                Application::$app->response->redirect('/');
            }
        }
    }

}
