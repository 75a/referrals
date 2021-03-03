<?php

namespace app\core;

use app\core\exception\NotFoundException;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }


    public function get($path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    public function onError(int $errorCode, $callback): void
    {
        $this->routes['error']["error " . $errorCode] = $callback;
    }

    public function onErrors(array $errorCodes, $callback): void
    {
        foreach ($errorCodes as $errorCode) {
            $this->routes['error']["error " . $errorCode] = $callback;
        }
    }

    public function onErrorDefault($callback): void
    {
        $this->routes['error']["default"] = $callback;
    }

    public function resolve(): ?string
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            throw new NotFoundException();
        }
        return $this->finalResolve($callback);
    }

    public function resolveError(\Exception $e): ?string
    {
        $callback = $this->routes["error"]["error " . $e->getCode()] ?? $callback = $this->routes["error"]["default"];
        $this->response->message = $e->getMessage();
        return $this->finalResolve($callback);
    }

    private function finalResolve($callback): ?string
    {
        if (is_array($callback)){
            /** @var Controller $controller */
            $controller = new $callback[0]();

            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
        }
        return call_user_func($callback, $this->request, $this->response);
    }


}