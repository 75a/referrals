<?php
/** @noinspection PhpUndefinedVariableInspection */
use function app\_;
use app\core\CSRFProtector;
?>

<h2 class="text-big"><?=_("Create an account")?></h2>
<form method="post">
    <input type="hidden" name="<?=CSRFProtector::CSRF_KEY?>" value="<?=CSRFProtector::getToken()?>">


    <?php if ($isEmailError ?? false): ?>
        <label for="email" class="text-small text-red text-bold"><?=$emailError?></label>
        <input type="text" class="form-control input-error" name="email" id="email" placeholder="E-mail" value="<?=$emailOld?>">
    <?php else: ?>
        <input type="text" class="form-control" name="email" placeholder="E-mail">
    <?php endif; ?>

    <input type="password" class="form-control" name="password" placeholder="Password">
    <input type="password" class="form-control" name="confirmPassword" placeholder="Repeat password">
    <button type="submit" class="btn">Register</button>
</form>

