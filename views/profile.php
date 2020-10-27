<?php
/** @var $this \app\core\View */

use app\core\Application;

?>

<h1><?=Application::$app->getText("Profile")?></h1>
<p><?=Application::$app->getText("Your e-mail")?>: <strong><?= $email ?></strong></p>
<p><?=Application::$app->getText("Your name")?>: <strong><?= $fullname ?></strong></p>
<p><?=Application::$app->getText("Your reflink")?>: <strong><a href="http://localhost:8080/r?code=<?= $reflink ?>">http://localhost:8080/r?code=<?= $reflink ?></a></strong></p>
<p><?=Application::$app->getText("Your points")?>: <strong><?= $points ?></strong></p>