<?php
/** @noinspection PhpUndefinedVariableInspection */
use function app\_;
use app\core\CSRFProtector;
?>

<h2 class="text-big">Login</h2>
<form method="post">
    <input type="hidden" name="<?=CSRFProtector::CSRF_KEY?>" value="<?=CSRFProtector::getToken()?>">
    <input type="text" class="form-control" name="email" placeholder="E-mail">
    <input type="password" class="form-control" name="password" placeholder="Password">
    <button type="submit" class="btn">Login</button>
</form>