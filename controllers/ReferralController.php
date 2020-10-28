<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\CSRFProtector;
use app\core\middlewares\LoggedInMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;
use app\models\RefClick;

class ReferralController extends Controller
{
    public function refclick()
    {
        if ($this->isValidRefClick()) {
            $newRef = new RefClick();
            $newRef->setIP($_SERVER['REMOTE_ADDR']);
            if ($newRef->setReferralCode($this->getReferralCode())){
                $newRef->save();
                if ($newRef->isSaved()){
                    Application::$app->session->setFlash('info',Application::$app->getText('Someone just got points'));
                } else {
                    Application::$app->session->setFlash('info',Application::$app->getText('This referral link has already been used'));
                }

                return Application::$app->response->redirect('/');
            }
        }
        Application::$app->session->setFlash('info',Application::$app->getText('This referral link is invalid'));
        return Application::$app->response->redirect('/');

    }

    private function isValidRefClick()
    {
        $refCode = Application::$app->request->getBody()['code'];
        if ($refCode)
        {
            return RefClick::isValidReferralCode($refCode);
        }
        return false;
    }

    private function getReferralCode(): string
    {
        return Application::$app->request->getBody()['code'];

    }

}