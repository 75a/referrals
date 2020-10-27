<?php

class m0006_add_verifycode_to_the_user_table{
    public function up(): void
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("ALTER TABLE users ADD COLUMN verifyCode VARCHAR(22);");
    }

    public function down(): void
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("ALTER TABLE users DROP COLUMN verifyCode;");
    }
}
