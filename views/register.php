<?php
/** @noinspection PhpUndefinedVariableInspection */
use function app\_;

use app\core\Application;
use app\core\CSRFProtector;
?>

<h2 class="text-big"><?=_("Create an account")?></h2>
<form method="post">
    <input type="hidden" name="<?=CSRFProtector::CSRF_KEY?>" value="<?=CSRFProtector::getToken()?>">

    <?php if ($isEmailError ?? false): ?>
        <input type="text" name="email" value="" class="input-error" placeholder="<?=$emailError?>">
    <?php else: ?>
        <input type="text" name="email" value="">
    <?php endif; ?>

    <input type="password" name="password" value="">
    <input type="password" name="confirmPassword" value="">
    <button type="submit" class="btn">Register</button>
</form>

