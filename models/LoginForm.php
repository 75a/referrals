<?php


namespace app\models;


use app\core\Application;
use app\core\Model;

class LoginForm extends Model
{

    public string $email = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'email' => Application::$app->getText("Your email"),
            'password' => Application::$app->getText("Password")
        ];
    }

    public function login()
    {
        $user = User::findOne(['email' => $this->email]);
        if (!$user) {
            $this->addError('email', Application::$app->getText('This e-mail is not registered'));
            return;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', Application::$app->getText('Password is incorrect'));
            return;
        }
        return Application::$app->login($user);
    }

}