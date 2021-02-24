<?php
/** @var $exception Exception */

use app\core\Application;

?>
<h2 class="text-big"><?php echo $exception->getCode() ?> - <?php echo Application::$app->getText($exception->getMessage()); ?></h2>