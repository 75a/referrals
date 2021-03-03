<?php
namespace app;
use app\core\Application;

function _(string $textToBeTranslated) {
    return Application::$app
        ->language::translate($textToBeTranslated);
}