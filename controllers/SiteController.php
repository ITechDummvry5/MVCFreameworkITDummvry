<?php 

namespace app\controllers;

use app\core\Controller;   // 👈 now PHP knows where to find Controller
use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;

class SiteController extends Controller {
    public function home() {
        $params = [
            'name' => "theThing"
        ];
        return $this->render('home', $params);
    }

public function contact(Request $request, Response $response) {
    $contact = new ContactForm();   // ✅ always create model

    if ($request->isPost()) {
        $contact->loadData($request->getBody());
        if ($contact->validate() && $contact->send()) {
            Application::$app->session->setflash_message('success', 'Thanks for contacting us!');
            // ✅ redirect only, no need to pass model here
            return $response->redirect('/contact');
        }
    }

    // ✅ always render with model
    return $this->render('contact', [
        'model' => $contact
    ]);
}
    public function profile(){
        return $this->render('profile');
    }


}
