<?php
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\core\Application;
use app\Config;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = Config::getConfig();

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/r', [SiteController::class, 'refclick']);

$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [Sitecontroller::class, 'contact']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->router->get('/profile', [AuthController::class, 'profile']);

$app->run();
