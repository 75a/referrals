<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\CSRFProtector;
use app\core\middlewares\LoggedInMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new LoggedInMiddleware(['contact']));
    }

    public function contact(Request $request, Response $response)
    {
        $contact = new ContactForm();
        CSRFProtector::setTokenIfNotExist();

        if ($request->isPost()) {
            $inputBody = $request->getBody();
            $userInputCSRF = $inputBody[CSRFProtector::CSRF_KEY];
            $contact->loadData($inputBody);
            if ($contact->validate() && $this->sendContactMessage($inputBody) && ($userInputCSRF === CSRFProtector::getToken())) {
                Application::$app->session->setFlash('info',Application::$app->getText('Thanks for contacting us.'));
                CSRFProtector::removeToken();
                return $response->redirect('/');
            }
        }
        return $this->render('contact', [
            'model' => $contact
        ]);
    }

    private function sendContactMessage(array $messageArray): bool
    {
        // todo
        return true;
    }

}