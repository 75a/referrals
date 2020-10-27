<?php

use app\Config;
use app\core\Application;

$app = Application::$app;
$this->title = $app->getText("Welcome to the home page!");
$reflink = Config::getConfig()['reflinkURL'] . $app->user->referralCode;
?>
<h2><?=$app->getText("Welcome")?>, <?=$userName?>! </h2>
<p><?=$app->getText("You will get a point for every click on your dedicated referral link.")?></p>
<p><?=$app->getText("Your link is presented below")?></p>
<a href="<?=$reflink?>"><?=$reflink?></a>