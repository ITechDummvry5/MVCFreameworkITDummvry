<?php 

namespace app\controllers;

use app\core\Controller;   // 👈 now PHP knows where to find Controller

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

    public function handleContact() {
        return 'Handling Contact Submitted data';
    }
}
