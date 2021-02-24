<?php

use app\core\Application;

$texts = Application::$app->language->getTexts();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $this->title ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="pt-15 pb-15 bg-dirtywhite bborder-1-brightgray">
        <div class="container">
            <h1>Referral Script</h1>
            <nav>
                <ul class="top-menu mt-8 mb-8">
                    <?php if (Application::isGuest()): ?>
                        <li class="mr-15"><a href="/" class="text-dark nav-button"><?= $texts['Home'] ?></a></li>
                        <li class="mr-15"><a href="/login" class="text-dark nav-button"><?= $texts['Login'] ?></a></li>
                        <li class="mr-15"><a href="register" class="text-dark nav-button"><?= $texts['Register'] ?></a></li>
                    <?php else: ?>
                        <li class="mr-15"><a href="/" class="text-dark nav-button"><?= $texts['Home'] ?></a></li>
                        <li class="mr-15"><a href="/profile" class="text-dark nav-button"><?= $texts['Profile'] ?></a></li>
                        <li class="mr-15"><a href="/contact" class="text-dark nav-button"><?= $texts['Contact'] ?></a></li>
                        <li class="mr-15"><a href="/logout" class="text-dark nav-button"><?= $texts['Logout'] ?></a></li>
                    <?php endif; ?>
                </ul>
                <p class="text-small">
                <?php if (Application::isGuest()): ?>
                    <?= $texts['You are not logged in'] ?>
                <?php else: ?>
                    <?= $texts['You are logged in as'] ?> <span class="text-bold"><?php echo Application::$app->user->getDisplayName() ?></span>
                <?php endif; ?>
                </p>
            </nav>
            <?php if (Application::$app->session->getFlash('info') !== ""): ?>

                    <p class="flash">
                        <?= $texts["Info"] ?>: <strong><?php echo Application::$app->session->getFlash('info') ?></strong>
                    </p>
            <?php endif; ?>

            <?php if (!Application::isGuest() && !Application::$app->user->isVerified()): ?>
                <p class="flash"><?=Application::$app->getText("Please click on the confirmation link we've sent you to your e-mail")?></p>
            <?php endif; ?>


        </div>
    </header>
    <main class="pt-25 pb-25">
        <div class="container">
            <div class="main-content">
                {{content}}
            </div>

        </div>
    </main>
    <footer class="main-footer bg-dark text-bright text-bold">
        <div class="container">
            <p><?= $texts["Michal Brzozowski 2020"] ?></p>
        </div>
    </footer>
</body>
</html>
