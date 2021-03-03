<?php


namespace app\core\handlers;


use app\core\Application;
use app\core\CSRFProtector;
use app\core\db\DbManager;
use app\models\User;

class LoginHandler
{
    private string $email;
    private string $password;
    private string $inputCsrf;

    public function __construct(array $userInputBody)
    {
        $this->email = $userInputBody["email"];
        $this->password = $userInputBody["password"];
        $this->inputCsrf = $userInputBody[CSRFProtector::CSRF_KEY];
    }

    public function authenticate(): bool
    {
        CSRFProtector::setTokenIfNotExists();
        if ((CSRFProtector::isValid($this->inputCsrf)) && $this->areCredentialsValid($this->email, $this->password) ){
            CSRFProtector::removeToken();
            return true;
        }
        return false;
    }

    private function areCredentialsValid(string $email, string $password): bool
    {
        $user = DbManager::findOne(User::class, ['email' => $email]);
        if (!$user) {
            return false;
        }
        if (!password_verify($password, $user->password)) {
            return false;
        }
        return Application::$app->login($user);
    }
}