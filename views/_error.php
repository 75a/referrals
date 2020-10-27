<?php
/** @var $exception Exception */

use app\core\Application;

?>
<h3><?php echo $exception->getCode() ?> - <?php echo Application::$app->getText($exception->getMessage()); ?></h3>