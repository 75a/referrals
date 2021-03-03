<?php


namespace app\core\views\builder;


use app\core\views\View;

interface IViewBuilder
{
    public function get(string $viewFileName, array $additionalParams = []): View;
}