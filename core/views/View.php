<?php


namespace app\core\views;


use app\core\Application;
use app\core\views\feeder\IViewFeeder;

class View
{
    private string $buffer;
    private string $viewFileName;
    private array $params;

    public function __construct($viewFileName, $params = [])
    {
        $this->viewFileName = $viewFileName;
        $this->params = $params;
    }

    public function yieldViewAs(View $view, string $as): void
    {
        $this->buffer = str_replace("{{{$as}}}", $view->getBuffer(), $this->buffer);
    }

    public function feed(IViewFeeder $viewFeeder)
    {
        $this->addParams($viewFeeder->getFeed());
    }

    public function addParams(array $params = [])
    {
        foreach ($params as $key => $value) {
            $this->params[$key] = $value;
        }
    }

    public function getBuffer(): string
    {
        return $this->buffer;
    }

    public function loadView(): void
    {
        foreach ($this->params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        /** @noinspection PhpIncludeInspection */
        include_once Application::$ROOT_DIR."/views/$this->viewFileName.php";
        $this->buffer = ob_get_clean();
    }

}