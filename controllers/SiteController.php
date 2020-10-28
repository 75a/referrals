<?php

namespace app\controllers;
use app\core\Application;
use app\core\Controller;
use app\core\CSRFProtector;
use app\core\middlewares\LoggedInMiddleware;
use app\core\Request;
use app\core\Response;
use app\locales\English;
use app\locales\Polish;
use app\models\ContactForm;
use app\models\RefClick;
use app\models\User;

class SiteController extends Controller
{


    public function home()
    {
        if (Application::$app->user){
            return $this->homeForRegistered();
        } else {
            return $this->homeForGuest();
        }
    }

    private function homeForRegistered()
    {
        $app = Application::$app;
        $params = [
            'userName' => Application::$app->user->getDisplayName()
        ];
        return $this->render('userHome', $params);
    }

    private function homeForGuest()
    {
        return $this->render('guestHome');
    }

}
