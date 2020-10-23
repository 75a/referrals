<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\LoggedInMiddleware;
use app\core\middlewares\GuestMiddleware;
use app\core\Request;
use app\core\Response;
use app\core\Utils;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new LoggedInMiddleware(['profile']));
        $this->registerMiddleware(new GuestMiddleware(['register', 'login']));
    }

    public function login (Request $request, Response $response)
    {
        $loginForm = new LoginForm();
        if ($request->isPost()){
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()){
                $response->redirect('/');
                return;
            }
        }

        $this->setLayout('main');
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }

    public function register(Request $request)
    {

        $user = new User();
        if ($request->isPost()){

           $user->loadData($request->getBody());


            if ($user->validate() && $user->setReferralCode() && $user->save()){
                Application::$app->session->setFlash(
                    'success',
                    'Thanks for registering'
                );
                Application::$app->response->redirect('/');
                exit;
            }



            return $this->render('register', [
                    'model' => $user
            ]);
        }
        $this->setLayout('main');
        return $this->render('register', [
            'model' => $user
        ]);
    }


    public function logout (Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function profile()
    {
        $user = Application::$app->user;
        return $this->render('profile', [
            'email' => $user->email,
            'fullname' => $user->getDisplayName(),
            'reflink' => $user->referralCode,
            'points' => $user->getPointsCount()
        ]);
    }

}