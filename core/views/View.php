<?php


namespace app\core;


class View
{
    private string $buffer;
    private string $viewFileName;
    private array $params;

    public function __construct($viewFileName, $params = [])
    {
        $this->viewFileName = $viewFileName;
        $this->params = $params;
        $this->loadView();
    }

    public function yield(View $view, string $spot): void
    {
        $this->buffer = str_replace("{{{$spot}}}", $view->getBuffer(), $this->buffer);
    }

    public function getBuffer(): string
    {
        return $this->buffer;
    }

    private function loadView(): void
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