<?php

namespace app\controllers;
use app\core\Application;
use app\core\Controller;
use app\core\views\builder\SingleLayoutYieldableViewBuilder;

class SiteController extends Controller
{
    public function home(): string
    {
        if (!Application::isGuest()){
            return $this->homeForRegistered();
        } else {
            return $this->homeForGuest();
        }
    }

    private function homeForRegistered(): string
    {
        $view = (new SingleLayoutYieldableViewBuilder())->get("userHome", [
            'userName' => Application::$app->user->getDisplayName()
        ]);
        return $view->getBuffer();
    }

    private function homeForGuest(): string
    {
        $view = (new SingleLayoutYieldableViewBuilder())->get("guestHome", [
            'userName' => "Guest"
        ]);
        return $view->getBuffer();
    }

}