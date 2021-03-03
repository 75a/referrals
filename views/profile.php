<?php
/** @noinspection PhpUndefinedVariableInspection */
use function app\_;

/** @var $this \app\core\View */

use app\Config;
use app\core\Application;

?>
<h2 class="text-big"><?=_("Profile")?></h2>
<p><?=_("Your e-mail")?>: <strong><?= $email ?></strong></p>
<p><?=_("Your reflink")?>: <strong><a href="<?= $reflink ?>"><?=$reflink?></a></strong></p>
<p><?=_("Your points")?>: <strong><?= $points ?></strong></p>
<p><?=_("Account status")?>: <strong><?=_("Status ".Application::$app->user->status) ?></strong></p>
