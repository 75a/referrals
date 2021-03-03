<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\Model;
use app\core\Utils;

class RefClick extends Model
{
    public const TABLE_NAME = "refclick";
    public const PRIMARY_KEY = "id";
    public const ATTRIBUTES = ['user_id','clicker_ip'];
    public const RULES = [
        'user_id' => [self::RULE_REQUIRED],
        'clicker_ip' => [self::RULE_REQUIRED]
    ];

    const REF_LENGTH = 8;

    public User $refUser;

    public int $id;
    public int $user_id;
    public string $clicker_ip;

    public static function generateNewReferralCode(): string
    {
        return Utils::getRandomString(self::REF_LENGTH);
    }

    public static function isValidReferralCode(string $potentialReferralCode): bool
    {
        return (ctype_alnum($potentialReferralCode) && (strlen($potentialReferralCode) == self::REF_LENGTH));
    }
}