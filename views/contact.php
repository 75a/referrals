<?php
/** @var $this \app\core\View */
/** @var $model \app\models\ContactForm */

use app\core\Application;
use app\core\CSRFProtector;
use app\core\form\TextareaField;
?>
<h2 class="text-big"><?=Application::$app->getText("Contact us")?></h2>
<?php $form = \app\core\form\Form::begin('', 'post'); ?>
    <?php echo $form->getCSRFField(CSRFProtector::getToken()) ?>
    <?php echo $form->field($model, 'subject') ?>
    <?php echo $form->field($model, 'email') ?>
    <?php echo new TextareaField($model, 'body') ?>
    <button type="submit" class="btn btn-primary"><?=Application::$app->getText("Submit")?></button>
<?php \app\core\form\Form::end() ?>

