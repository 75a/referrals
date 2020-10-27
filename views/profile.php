<?php
/** @var $this \app\core\View */

use app\Config;
use app\core\Application;

$reflink = Config::getConfig()['reflinkURL'] . $reflink;
?>

<h1><?=Application::$app->getText("Profile")?></h1>
<p><?=Application::$app->getText("Your e-mail")?>: <strong><?= $email ?></strong></p>
<p><?=Application::$app->getText("Your name")?>: <strong><?= $fullname ?></strong></p>
<p><?=Application::$app->getText("Your reflink")?>: <strong><a href="<?= $reflink ?>"><?=$reflink?></a></strong></p>
<p><?=Application::$app->getText("Your points")?>: <strong><?= $points ?></strong></p>