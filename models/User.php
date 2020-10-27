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
        return ['firstname', 'lastname', 'email', 'password', 'status', 'referralCode'];
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

    public function getReferralCode(): string
    {
        return $this->referralCode;
    }

    public function getPointsCount(): int
    {
        return DbModel::count("refclick",[
            "refowner" => $this->id
        ]);
    }




}