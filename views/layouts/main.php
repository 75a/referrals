<?php

use app\core\Application;

$texts = Application::$app->language->getTexts();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $this->title ?></title>
    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            width: 80%;
            margin: auto;
        }

        .top-menu li {
            display: inline;
            margin: 0 10px 0 10px;
        }

        .flash {
            background-color: #51d92b;
        }

        .main-content {
            border: 1px solid #000000;
        }

        header {
            margin: 50px 0 50px 0;
        }

        footer {
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Referral Script</h1>
            <nav>
                <ul class="top-menu">
                    <?php if (Application::isGuest()): ?>
                        <li><a href="/"><?= $texts['Home'] ?></a></li>
                        <li><a href="/login"><?= $texts['Login'] ?></a></li>
                        <li><a href="register"><?= $texts['Register'] ?></a></li>
                    <?php else: ?>
                        <li><a href="/"><?= $texts['Home'] ?></a></li>
                        <li><a href="/profile"><?= $texts['Profile'] ?></a></li>
                        <li><a href="/contact"><?= $texts['Contact'] ?></a></li>
                        <li><a href="/logout"><?= $texts['Logout'] ?></a></li>
                    <?php endif; ?>
                </ul>
                <?php if (Application::isGuest()): ?>
                    <p><?= $texts['You are not logged in'] ?></p>
                <?php else: ?>
                    <p><?= $texts['You are logged in as'] ?> <?php echo Application::$app->user->getDisplayName() ?></p>
                <?php endif; ?>
            </nav>
            <?php if (Application::$app->session->getFlash('success')): ?>
                <div class="flash">
                    <p><?= $texts["Info"] ?>: <strong><?php echo Application::$app->session->getFlash('success') ?></strong>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <div class="container main-content">
            {{content}}
        </div>
    </main>
    <footer>
        <div class="container">
            <p><?= $texts["Michal Brzozowski 2020"] ?></p>
        </div>
    </footer>
</body>
</html>
