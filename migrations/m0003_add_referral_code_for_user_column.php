<?php

class m0003_add_referral_code_for_user_column{
    public function up(): void
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("ALTER TABLE users ADD COLUMN referralCode VARCHAR(8) NOT NULL");
    }

    public function down(): void
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("ALTER TABLE users DROP COLUMN referralCode;");
    }
}
