<?php

namespace app\controllers;   // 👈 add this so Router can find it

use app\core\Controller;   // 👈 now PHP knows where to find Controller
use app\core\Application;
use app\core\Request;

class AuthController extends Controller{
    public function login(){
        $this->setLayout('auth');
        return $this->render('login');
    }

        public function register(Request $request){
        if($request->isPost()){
            // Handle registration logic
           
        }
        $this->setLayout('auth');
        return $this->render('register');
    }
}