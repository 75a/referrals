<?php


namespace app\core\views\builder;


use app\core\views\feeder\MainLayoutFeeder;
use app\core\views\View;

class ViewBuilder implements IViewBuilder
{

    public function get(string $viewFileName, array $additionalParams = []): View
    {
        $view = new View($viewFileName);
        $view->addParams($additionalParams);
        $view->loadView();
        return $view;
    }
}