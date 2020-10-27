<?php

class m0005_add_points_to_the_user_table{
    public function up(): void
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("ALTER TABLE users ADD COLUMN points INT DEFAULT '0' NOT NULL");
    }

    public function down(): void
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("ALTER TABLE users DROP COLUMN points;");
    }
}
