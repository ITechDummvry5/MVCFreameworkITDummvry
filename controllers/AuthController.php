<?php

namespace app\controllers;   // 👈 add this so Router can find it

use app\core\Controller;   // 👈 now PHP knows where to find Controller
use app\core\Application;
use app\core\Request;
use app\models\RegisterModel;  // 👈 import the RegisterModel class clear


class AuthController extends Controller{
    public function login(){
        $this->setLayout('auth');
        return $this->render('login');
    }

        public function register(Request $request){
        $registerModel = new RegisterModel();
        if($request->isPost()){
           
            $registerModel->loadData($request->getBody());


            if($registerModel->validate() && $registerModel->register()) { 
                return 'Success';
        }
        
            // echo '<pre>';
            // var_dump($registerModel->errors);
            // echo '</pre>';

        return $this->render('register' , [
            'model' => $registerModel
        ]);
    }
        $this->setLayout('auth');
           return $this->render('register' , [
            'model' => $registerModel
        ]);
    }
    }
