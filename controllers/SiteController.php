<?php

namespace app\controllers;
use app\core\Application;
use app\core\Controller;
use app\core\middlewares\LoggedInMiddleware;
use app\core\Request;
use app\core\Response;
use app\locales\English;
use app\locales\Polish;
use app\models\ContactForm;
use app\models\RefClick;
use app\models\User;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new LoggedInMiddleware(['contact']));
    }

    public function home()
    {
        if (Application::$app->user){
            return $this->homeForRegistered();
        } else {
            return $this->homeForGuest();
        }
    }

    public function refclick()
    {
        if ($this->isValidRefClick()) {
            $newRef = new RefClick();
            $newRef->setIP($_SERVER['REMOTE_ADDR']);
            $newRef->setReferralCode($this->getReferralCode());
            $newRef->save();
            if ($newRef->isSaved()){
                Application::$app->session->setFlash('success',Application::$app->getText('Someone just got points'));
            } else {
                Application::$app->session->setFlash('success',Application::$app->getText('This referral link has already been used'));
            }

            return Application::$app->response->redirect('/');
        } else {
            Application::$app->session->setFlash('success',Application::$app->getText('This referral link is invalid'));
            return Application::$app->response->redirect('/');
        }

    }

    public function contact(Request $request, Response $response)
    {
        $contact = new ContactForm();
        if ($request->isPost()) {
            $contact->loadData($request->getBody());
            if ($contact->validate() && $contact->send()) {
                Application::$app->session->setFlash('success',Application::$app->getText('Thanks for contacting us.'));
                return $response->redirect('/contact');
            }
        }
        return $this->render('contact', [
            'model' => $contact
        ]);
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

    private function homeForRegistered()
    {
        $app = Application::$app;
        $params = [
            'translate' => [
                'Welcome' => $app->getText('Welcome'),
            ],
            'userName' => Application::$app->user->getDisplayName(),
            'title' => 'xd'
        ];
        return $this->render('userHome', $params);
    }

    private function homeForGuest()
    {

        return $this->render('guestHome');
    }

}
