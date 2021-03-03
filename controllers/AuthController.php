<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\CSRFProtector;
use app\core\flash\ErrorFlash;
use app\core\flash\SuccessFlash;
use app\core\handlers\LoginHandler;
use app\core\handlers\RegisterHandler;
use app\core\middlewares\LoggedInMiddleware;
use app\core\middlewares\GuestMiddleware;
use app\core\Request;
use app\core\Response;
use app\core\views\builder\SingleLayoutYieldableViewBuilder;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new LoggedInMiddleware(['logout']));
        $this->registerMiddleware(new GuestMiddleware(['showRegister', 'showLogin']));
    }

    public function showLogin(): string
    {
        CSRFProtector::setTokenIfNotExists();
        return (new SingleLayoutYieldableViewBuilder())->get("login")->getBuffer();
    }

    public function showRegister(): string
    {
        CSRFProtector::setTokenIfNotExists();
        return (new SingleLayoutYieldableViewBuilder())->get("register")->getBuffer();
    }

    public function login (Request $request, Response $response): void
    {
        $loginHandler = new LoginHandler($request->getBody());
        $loggedIn = $loginHandler->authenticate();
        if ($loggedIn) {
            Application::$app->session->setFlash(new SuccessFlash("Logged in successfully"));
            Application::$app->response->redirect('/');
            return;
        }
        $response->redirect('/');
    }

    public function logout (Request $request, Response $response): void
    {
        Application::$app->logout();
        Application::$app->session->setFlash(
            new SuccessFlash("You have been logged out")
        );
        $response->redirect('/');
    }

    public function register(Request $request, Response $response): ?string
    {
        $registerHandler = new RegisterHandler($request->getBody());
        if ($registerHandler->registerUser()) {
            Application::$app->session->setFlash(
                new SuccessFlash("Logged in successfully")
            );
            $response->redirect('/');
            return null;
        }

        $errors = $registerHandler->getValidationErrors();
        $response->setStatusCode(403);
        return (new SingleLayoutYieldableViewBuilder())->get("register", [
            "isEmailError" => ($errors['email'] !== ''),
            "emailError" => $errors['email'],
            "emailOld" => $request->getBody()['email'],

            "isPasswordError" => ($errors['password'] !== ''),
            "passwordError" => $errors['password'],

            "isPasswordConfirmationError" => ($errors['confirmPassword'] !== ''),
            "passwordConfirmationError" => $errors['confirmPassword']
        ])->getBuffer();
    }

}