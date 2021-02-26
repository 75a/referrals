<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\Utils;

class RefClick extends DbModel
{
    public const REF_LENGTH = 8;

    public DbModel $refUser;

    public int $user_id;
    public string $clicker_ip;

    public bool $isSaved = false;

    public static function generateNewReferralCode(): string
    {
        return Utils::getRandomString(self::REF_LENGTH);
    }

    public static function isValidReferralCode(string $potentialReferralCode): bool
    {
        return (ctype_alnum($potentialReferralCode) && (strlen($potentialReferralCode) == self::REF_LENGTH));
    }

    public function save(): bool
    {
        if ($this->user_id && $this->clicker_ip) {

            $existingClick = (new RefClick)->findOne([
                'user_id' => $this->user_id,
                'clicker_ip' => $this->clicker_ip
            ]);
            if (!$existingClick){
                $this->isSaved = true;
                $this->refUser->addPoints(1);

                return parent::save();
            }
        }
        return false;
    }

    public function isSaved(): bool
    {
        return $this->isSaved;
    }

    public function rules(): array
    {
        return [
            'user_id' => [self::RULE_REQUIRED],
            'clicker_ip' => [self::RULE_REQUIRED]
        ];
    }

    public function tableName(): string
    {
        return "refclick";
    }

    public function attributes(): array
    {
        return ['user_id','clicker_ip'];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function setReferralCode(String $referralCode): bool
    {
        $user = (new User)->findOne(['referral_code' => $referralCode]);
        if ($user){
            $this->refUser = $user;
            $this->user_id = $user->id;
            return true;
        }
        return false;
    }

    public function setIP(String $ip): void
    {
        $this->clicker_ip = $ip;
    }
}