<?php 

namespace app\controllers;

use app\core\Controller;   // 👈 now PHP knows where to find Controller
use app\core\Application;
use app\core\Request;

class SiteController extends Controller {
    public function home() {
        $params = [
            'name' => "theThing"
        ];
        return $this->render('home', $params);
    }

    public function contact() {
        return $this->render('contact');
    }

    public function profile(){
        return $this->render('profile');
    }

    public function handleContact(Request $request) {
        // first Method with instance the Request $request
        $body = $request->getBody();
        // Second Method without instance the Request $request
    // $body = Application::$app->request->getBody();
        return 'Handling Contact Submitted data';
    }
}
