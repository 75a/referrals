<?php

namespace app\core\views\feeder;

use app\core\Application;

class MainLayoutFeeder implements IViewFeeder
{
    private array $params = [];

    public function getFeed(): array
    {
        $isFlashSet = Application::$app->session->isFlashSet();
        $isGuestUser = Application::isGuest();

        $this->params = [
            'metaTitle' => "Meta Title Sample",
            'isFlashSet' => $isFlashSet,
            'isGuestUser' => $isGuestUser,
            'htmlLang' => Application::$app->language::getLanguageCodeForHTMLDocument(),
        ];

        $this->addFlashData();
        $this->addUserData();

        return $this->params;
    }

    private function addFlashData(): void
    {
        if ($this->params['isFlashSet']) {
            $session = Application::$app->session;
            $this->params['flashMessage'] =       $session->getFlash()->getMessage();
            $this->params['flashStyleClass'] =    $session->getFlash()->getStyleClass();
            $this->params['flashTypeName'] =      $session->getFlash()->getTypeName();
        }
    }

    private function addUserData(): void
    {
        if (!$this->params['isGuestUser']) {
            $this->params['userDisplayName'] = Application::$app->user->getDisplayName();
        }
    }
}