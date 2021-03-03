<?php
    /** @noinspection PhpUndefinedVariableInspection */
    use function app\_;
?>

<!doctype html>
<html lang="<?=$htmlLang?>">
<head>
    <meta charset="utf-8">
    <title><?=$metaTitle?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="pt-15 pb-15 bg-dirtywhite bborder-1-brightgray">
        <div class="container">
            <h1>Referral Script</h1>
            <nav>
                <ul class="top-menu mt-8 mb-8">
                    <li class="mr-15"><a href="/" class="text-dark nav-button"><?= _('Home')?></a></li>
                    <?php if ($isGuestUser): ?>
                        <li class="mr-15"><a href="/login" class="text-dark nav-button"><?=_('Login')?></a></li>
                        <li class="mr-15"><a href="register" class="text-dark nav-button"><?=_('Register')?></a></li>
                    <?php else: ?>
                        <li class="mr-15"><a href="/profile" class="text-dark nav-button"><?=_('Profile')?></a></li>
                        <li class="mr-15"><a href="/logout" class="text-dark nav-button"><?=_('Logout')?></a></li>
                    <?php endif; ?>
                </ul>
                <p class="text-small">
                <?php if ($isGuestUser): ?>
                    <?=_('You are not logged in')?>
                <?php else: ?>
                    <?=_('You are logged in as')?> <span class="text-bold"><?=$userDisplayName?></span>
                <?php endif; ?>
                </p>
            </nav>
            <?php if ($isFlashSet): ?>
                    <p class="flash <?=$flashStyleClass?>">
                        <?=$flashTypeName?>: <strong><?=_($flashMessage)?></strong>
                    </p>
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
            <p><?=_("Copyright &copy; 2020")?></p>
        </div>
    </footer>
</body>
</html>
