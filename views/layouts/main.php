<?php
    use app\core\Application;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Hello World</title>
</head>
<body>
        <?php if (Application::$app->session->getFlash('success')): ?>
            <div>
                <p style="color: #00ff00">Flash Info: <strong><?php echo Application::$app->session->getFlash('success') ?></strong></p>
            </div>
        <?php endif; ?>
        <?php if (Application::isGuest()): ?>
            <p>You are not logged in.</p>
        <?php else:  ?>
            <p>You are logged in as <?php echo Application::$app->user->getDisplayName() ?></p>
        <?php endif; ?>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/logout">Logout</a></li>
            <li><a href="/login">Login</a></li>
            <li><a href="/register">Register</a></li>
            <li><a href="/profile">Profile</a></li>
            <li><a href="/contact">Contact</a></li>
        </ul>
        <h1>This page content:</h1>
        <hr>
        <div>
            {{content}}
        </div>
</body>
</html>
