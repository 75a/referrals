<?php

use app\controllers\ContactController;
use app\controllers\ProfileController;
use app\controllers\ReferralController;
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\core\Application;
use app\Config;
use app\locales\English;
use app\locales\Polish;


require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = Config::getConfig();

$app = new Application(dirname(__DIR__), $config);

$app->language = new Polish();

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/r', [ReferralController::class, 'refclick']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->router->get('/profile', [ProfileController::class, 'profile']);

$app->run();
