<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\Utils;

class RefClick extends DbModel
{
    public const REF_LENGTH = 8;

    public DbModel $refUser;
    public int $refowner;
    public string $ipofclicker;
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
        if ($this->refowner && $this->ipofclicker) {

            $existingClick = (new RefClick)->findOne([
                'refowner' => $this->refowner,
                'ipofclicker' => $this->ipofclicker
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
            'refowner' => [self::RULE_REQUIRED],
            'ipofclicker' => [self::RULE_REQUIRED]
        ];
    }

    public function tableName(): string
    {
        return "refclick";
    }

    public function attributes(): array
    {
        return ['refowner','ipofclicker'];
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
            $this->refowner = $user->id;
            return true;
        }
        return false;
    }

    public function setIP(String $ip): void
    {
        $this->ipofclicker = $ip;
    }
}