<?php


namespace app\core\handlers;

use app\core\Application;
use app\core\CSRFProtector;
use app\core\db\DbManager;
use app\models\User;
use DateTime;

class RegisterHandler
{
    private array $inputBody;
    private array $validationErrors = [];

    public function __construct(array $inputBody)
    {
        $this->inputBody = $inputBody;
    }

    public function registerUser(): bool
    {
        CSRFProtector::setTokenIfNotExists();
        $user = new User();
        $user->loadData($this->inputBody);
        if (!$user->validate()) {
            foreach (User::rules() as $ruleName => $rule) {
                $this->validationErrors[$ruleName] = $user->getFirstError($ruleName);
            }
            return false;
        }

        $user->created_at = (new Datetime('now'))->format('Y-m-d H:i:s');
        $user->setReferralCode();

        $inputCsrf = $this->inputBody[CSRFProtector::CSRF_KEY];
        if (CSRFProtector::isValid($inputCsrf)){
            CSRFProtector::removeToken();
            $user->password = strval(password_hash($user->password, PASSWORD_DEFAULT));

            $user->id = DbManager::add($user);
            Application::$app->login($user);
            return true;
        }
         return false;
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }
}