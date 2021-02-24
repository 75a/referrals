<?php
/** @var $model \app\models\User */

use app\core\Application;
use app\core\CSRFProtector;

?>

<h2 class="text-big">Login</h2>
<?php $form = \app\core\form\Form::begin('',"post") ?>
    <?php echo $form->getCSRFField(CSRFProtector::getToken()) ?>
    <?php echo $form->field($model, 'email') ?>
    <?php echo $form->field($model, 'password')->passwordField() ?>
    <button type="submit" class="btn btn-primary"><?=Application::$app->getText("Submit")?></button>
<?php \app\core\form\Form::end() ?>
