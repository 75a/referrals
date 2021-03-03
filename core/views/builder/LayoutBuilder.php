<?php


namespace app\core\views\builder;


use app\core\views\feeder\MainLayoutFeeder;
use app\core\views\View;

class LayoutBuilder implements IViewBuilder
{

    public function get(string $viewFileName = "layouts/main", array $additionalParams = []): View
    {
        $layout = new View($viewFileName);
        $layout->feed(new MainLayoutFeeder);
        $layout->addParams($additionalParams);
        $layout->loadView();
        return $layout;
    }
}