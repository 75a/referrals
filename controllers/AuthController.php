<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\CSRFProtector;
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
        CSRFProtector::setTokenIfNotExist();
        if ($request->isPost()){

            $inputBody = $request->getBody();
            $loginForm->loadData($inputBody);
            $userInputCSRF = $inputBody[CSRFProtector::CSRF_KEY];
            if (($userInputCSRF === CSRFProtector::getToken()) && $loginForm->validate() && $loginForm->login() ){
                Application::$app->session->setFlash(
                    'info',
                    Application::$app->getText('Logged in successfully!')
                );
                CSRFProtector::removeToken();
                return $response->redirect('/');

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
        CSRFProtector::setTokenIfNotExist();
        if ($request->isPost()){
            $inputBody = $request->getBody();
            $user->loadData($inputBody);
            $userInputCSRF = $inputBody[CSRFProtector::CSRF_KEY];
            if (($userInputCSRF === CSRFProtector::getToken()) && $user->validate() && $user->save()){
                $user->loadId();

                Application::$app->login($user);
                Application::$app->session->setFlash(
                    'success',
                    Application::$app->getText('Thanks for registering')
                );
                CSRFProtector::removeToken();
                return Application::$app->response->redirect('/');
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
            'reflink' => $user->referral_code,
            'points' => $user->points
        ]);
    }

}