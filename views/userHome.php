<?php
/** @noinspection PhpUndefinedVariableInspection */
use function app\_;

use app\Config;
use app\core\Application;

$app = Application::$app;
$this->title = _("Welcome to the home page!");
$reflink = $app->user->referral_code;
?>


<h2 class="text-big"><?=_("Welcome")?>, <?=$userName?>! </h2>
<p><?=_("You will get a point for every click on your dedicated referral link.")?></p>
<p><?_("Your link is presented below")?></p>
<a href="<?=$reflink?>"><?=$reflink?></a>