<?php
/** @noinspection PhpUndefinedVariableInspection */
use function app\_;
?>
<h2 class="text-big"><?=_("Profile")?></h2>
<p><?=_("Your e-mail")?>: <strong><?= $email ?></strong></p>
<p><?=_("Your reflink")?>: <strong><a href="<?=$reflink?>">localhost:8080<?=$reflink?></a></strong></p>
<p><?=_("Your points")?>: <strong><?= $points ?></strong></p>
