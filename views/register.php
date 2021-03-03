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

    <?php if ($isPasswordError ?? false): ?>
        <label for="password" class="text-small text-red text-bold"><?=$passwordError?></label>
        <input type="password" class="form-control input-error" name="password" id="password" placeholder="Password">
    <?php else: ?>
        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    <?php endif; ?>

    <?php if ($isPasswordConfirmationError ?? false): ?>
        <label for="confirmPassword" class="text-small text-red text-bold"><?=$passwordConfirmationError?></label>
        <input type="password" class="form-control input-error" name="confirmPassword" id="confirmPassword" placeholder="Repeat password">
    <?php else: ?>
        <input type="password" class="form-control" name="confirmPassword"  id="confirmPassword" placeholder="Repeat password">
    <?php endif; ?>
    <button type="submit" class="btn">Register</button>
</form>

