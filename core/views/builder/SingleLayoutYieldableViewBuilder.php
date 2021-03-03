<?php


namespace app\core\views\builder;


use app\core\views\View;

class SingleLayoutYieldableViewBuilder implements IViewBuilder
{

    public function get(string $viewFileName, array $additionalParams = []): View
    {
        $layout =   (new LayoutBuilder())->get();
        $yieldable = (new ViewBuilder())->get($viewFileName, $additionalParams);
        $layout->yieldViewAs($yieldable, "content");
        return $layout;
    }
}