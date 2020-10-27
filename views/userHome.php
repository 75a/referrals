<?php

use app\core\Application;

$this->title = Application::$app->getText("Welcome to the home page!");
?>
<h2><?=Application::$app->getText("Welcome")?>, <?=$userName?>! </h2>
