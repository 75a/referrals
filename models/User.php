<?php

namespace app\models;

use app\core\Application;
use app\core\db\DbModel;

use app\core\Model;
use app\core\UserModel;
use app\core\Utils;

class User extends UserModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;


    public int $id;
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $confirmPassword = '';
    public string $referralCode = '';
    public int $points = 0;
    public string $verifyCode;

    public function tableName(): string
    {
        return 'users';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->setReferralCode();
        $this->setVerificationCode();
        return parent::save();
    }


    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function attributes(): array
    {
        return ['firstname', 'lastname', 'email', 'password', 'status', 'referralCode', 'points', 'verifyCode'];
    }

    public function labels(): array
    {
        return [
            'firstname' => Application::$app->getText("First name"),
            'lastname' => Application::$app->getText("Last name"),
            'email' => Application::$app->getText("E-mail"),
            'password' => Application::$app->getText("Password"),
            'confirmPassword' => Application::$app->getText("Repeat password")
        ];
    }

    public function getDisplayName(): string
    {
        return $this->firstname.' '.$this->lastname;
    }

    public function setReferralCode(): bool
    {
        $newReferralCode = RefClick::generateNewReferralCode();
        $this->referralCode = $newReferralCode;
        return true;
    }

    public function setVerificationCode()
    {
        $this->verifyCode = Utils::getRandomString(22);
    }

    public function getReferralCode(): string
    {
        return $this->referralCode;
    }

    public function addPoints(int $points)
    {
        $this->points += $points;
        parent::updateColumn('points');
    }

    public function verify()
    {
        if ($this->status === self::STATUS_INACTIVE) {
            $this->status = self::STATUS_ACTIVE;
            parent::updateColumn('status');
        } else {
            echo "Nah";
        }
    }

    public function isVerified(): bool
    {
        return ($this->status === self::STATUS_ACTIVE);
    }

}