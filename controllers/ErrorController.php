<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\core\views\builder\SingleLayoutYieldableViewBuilder;


class ErrorController extends Controller
{
    public function httpError(Request $request, Response $response)
    {
        return (new SingleLayoutYieldableViewBuilder())->get("errors/httpError", [
            "errorCode" => $response->getStatusCode(),
            "errorMessage" => $response->message,
        ])->getBuffer();
    }

    public function error(Request $request, Response $response)
    {
        return (new SingleLayoutYieldableViewBuilder())->get("errors/error", [
            "errorMessage" => $response->message,
        ])->getBuffer();
    }

}