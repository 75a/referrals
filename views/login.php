<?php
/** @noinspection PhpUndefinedVariableInspection */
use function app\_;
use app\core\CSRFProtector;
?>

<h2 class="text-big">Login</h2>
<form method="post">
    <input type="hidden" name="<?=CSRFProtector::CSRF_KEY?>" value="<?=CSRFProtector::getToken()?>">
    <input type="text" name="email" value="asdasd@123.com">
    <input type="password" name="password" value="asdasd123">
    <button type="submit" class="btn">Login</button>
</form>