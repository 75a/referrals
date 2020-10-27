<?php


namespace app\models;


use app\core\db\DbModel;
use app\core\Utils;

class RefClick extends DbModel
{
    public const REF_LENGTH = 8;

    public User $refUser;
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

    public function save()
    {
        if ($this->refowner && $this->ipofclicker) {

            $existingClick = RefClick::findOne([
                'refowner' => $this->refowner,
                'ipofclicker' => $this->ipofclicker
            ]);
            if (!$existingClick){
                $this->isSaved = true;
                $this->refUser->addPoints(1);

                return parent::save();
            }
        }
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

    public function setReferralCode(String $referralCode): void
    {
        $user = User::findOne(['referralCode' => $referralCode]);
        if ($user){
            $this->refUser = $user;
            $this->refowner = $user->id;
        }
    }

    public function setIP(String $ip): void
    {
        $this->ipofclicker = $ip;
    }
}