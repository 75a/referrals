<?php

class m0004_add_refclick{
    public function up(): void
    {
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE refclick (
            id INT AUTO_INCREMENT PRIMARY KEY,
            refowner INT NOT NULL,
            ipofclicker VARCHAR(16) NOT NULL,
            foreign key (refowner) REFERENCES users(id)
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down(): void
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("DROP TABLE refclick;");
    }
}
