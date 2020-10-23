<?php
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\Config;
use app\core\Application;

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$config = Config::getConfig();
$app = new Application(__DIR__, $config);
$app->db->applyMigrations();