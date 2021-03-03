<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\Model;

class User extends Model
{
    public const TABLE_NAME = "users";
    public const PRIMARY_KEY = "id";
    public const ATTRIBUTES = [
        'email',
        'password',
        'status',
        'created_at',
        'referral_code',
        'points'
    ];

    public const RULES = [
        'email' => [
            self::RULE_REQUIRED,
            self::RULE_EMAIL,
            [self::RULE_UNIQUE, 'class' => User::class]
        ],
        'password' => [
            self::RULE_REQUIRED,
            [self::RULE_MIN, 'min' => 8],
            [self::RULE_MAX, 'max' => 24]
        ],
        'confirmPassword' => [
            self::RULE_REQUIRED,
            [self::RULE_MATCH, 'match' => 'password']
        ],
    ];

    public const LABELS = [
        'email' => "E-mail",
        'password' => "Password",
        'confirmPassword' => "Repeat password"
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public int $id;
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $created_at;
    public string $password = '';
    public string $referral_code = '';
    public int $points = 0;

    public string $confirmPassword = '';

    public function getDisplayName(): string
    {
        return $this->email;
    }

    public function setReferralCode(): bool
    {
        $newReferralCode = RefClick::generateNewReferralCode();
        $this->referral_code = $newReferralCode;
        return true;
    }

    public function getReferralCode(): string
    {
        return $this->referral_code;
    }

    public function addPoints(int $points)
    {
        $this->points += $points;
    }
}
