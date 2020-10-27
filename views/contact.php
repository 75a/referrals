<?php
/** @var $this \app\core\View */
/** @var $model \app\models\ContactForm */

use app\core\Application;
use app\core\form\TextareaField;
?>
<h1><?=Application::$app->getText("Contact us")?></h1>
<?php $form = \app\core\form\Form::begin('', 'post'); ?>
    <?php echo $form->field($model, 'subject') ?>
    <?php echo $form->field($model, 'email') ?>
    <?php echo new TextareaField($model, 'body') ?>
    <button type="submit" class="btn btn-primary"><?=Application::$app->getText("Submit")?></button>
<?php \app\core\form\Form::end() ?>

