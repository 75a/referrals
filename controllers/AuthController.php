<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\Mailer;
use app\core\middlewares\LoggedInMiddleware;
use app\core\middlewares\GuestMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new LoggedInMiddleware(['logout']));
        $this->registerMiddleware(new GuestMiddleware(['register', 'login']));
    }

    public function login (Request $request, Response $response)
    {
        $loginForm = new LoginForm();
        if ($request->isPost()){
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()){
                Application::$app->session->setFlash(
                    'info',
                    Application::$app->getText('Logged in successfully!')
                );
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

            if ($user->validate() && $user->save()){
                $user->loadId();

                $mailer = new Mailer();
                $mailer->sendEmail(
                    $user->email,
                    "Confirm your registration",
                    "Here's your verification code: {$user->verifyCode}"
                ); // TEST!

                Application::$app->login($user);
                Application::$app->session->setFlash(
                    'success',
                    Application::$app->getText('Thanks for registering')
                );
                Application::$app->response->redirect('/');
                return;
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
        Application::$app->session->setFlash(
            'info',
            Application::$app->getText('You have been logged out')
        );
        $response->redirect('/');
    }

    public function profile()
    {
        $user = Application::$app->user;
        return $this->render('profile', [
            'email' => $user->email,
            'fullname' => $user->getDisplayName(),
            'reflink' => $user->referralCode,
            'points' => $user->points
        ]);
    }

}