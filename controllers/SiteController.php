<?php

namespace app\controllers;
use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;
use app\models\RefClick;
use app\models\User;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            'name' => "TheCodeholicx",
            'referralCode' => "nie ma",
            'test' => 'test'
        ];

        if (Application::$app->user){
            $params['referralCode'] = Application::$app->user->getReferralCode();
        }

        return $this->render('home', $params);
    }

    public function refclick()
    {
        if ($this->isValidRefClick()) {
            $newRef = new RefClick();
            $newRef->setIP($_SERVER['REMOTE_ADDR']);
            $newRef->setReferralCode($this->getReferralCode());
            $newRef->save();
            if ($newRef->isSaved()){
                Application::$app->session->setFlash('success','Someone just got points');
            } else {
                Application::$app->session->setFlash('success','This referral link has already been used');
            }

            return Application::$app->response->redirect('/');
        } else {
            Application::$app->session->setFlash('success','This referral link is invalid');
            return Application::$app->response->redirect('/');
        }

    }

    public function contact(Request $request, Response $response)
    {
        $contact = new ContactForm();
        if ($request->isPost()) {
            $contact->loadData($request->getBody());
            if ($contact->validate() && $contact->send()) {
                Application::$app->session->setFlash('success','Thanks for contacting us.');
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

}
