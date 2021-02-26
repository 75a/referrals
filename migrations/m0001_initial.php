<?php

class m0001_initial{
    public function up(): void
    {
        $db = \app\core\Application::$app->db;
        $SQL = "
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL,
                status TINYINT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                password VARCHAR(255) NOT NULL,
                referral_code VARCHAR(8) NOT NULL,
                points INT NOT NULL DEFAULT 0
            ) ENGINE=INNODB;
            CREATE TABLE refclick (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                clicker_ip VARCHAR(255) NOT NULL,
                FOREIGN KEY (user_id) REFERENCES users(id)
            ) ENGINE=INNODB;
        ";
        $db->pdo->exec($SQL);
    }

    public function down(): void
    {
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE refclick;DROP TABLE users;";
        $db->pdo->exec($SQL);
    }
}