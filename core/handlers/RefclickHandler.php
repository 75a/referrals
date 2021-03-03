<?php


namespace app\core\handlers;

use app\core\db\DbManager;
use app\models\RefClick;
use app\models\User;

class RefclickHandler
{
    private string $refCode;

    public function __construct(string $refCode)
    {
        $this->refCode = $refCode;
    }

    public function isValidRefclick(): bool
    {
        return RefClick::isValidReferralCode($this->refCode);
    }

    public function registerNewClick(): bool
    {
        $newRef = new RefClick();
        $newRef->clicker_ip = $_SERVER['REMOTE_ADDR'];

        $user = DbManager::findOne(User::class, ['referral_code' => $this->refCode]);

        if ($user){
            $newRef->refUser = $user;
            $newRef->user_id = $user->id;

            $existingRef = DbManager::findOne(RefClick::class, [
                'user_id' => $newRef->user_id,
                'clicker_ip' => $newRef->clicker_ip
            ]);
            if ($existingRef === false) {
                DbManager::add($newRef);
                $user->addPoints(1);
                DbManager::update($user);

                return true;
            }

        }
        return false;
    }
}