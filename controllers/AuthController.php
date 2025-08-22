<?php

namespace app\controllers;   // 👈 add this so Router can find it

use app\core\Controller;   // 👈 now PHP knows where to find Controller
use app\core\Application;
use app\core\Request;
use app\models\User;  // 👈 import the User Model class clear


class AuthController extends Controller{
    public function login(){
        $this->setLayout('auth');
        return $this->render('login');
    }
    // Registerd new User in Db using model User and DbModel
        public function register(Request $request){
        $user = new User();
        if($request->isPost()){

            $user->loadData($request->getBody());


            if($user->validate() && $user->registered()) { 
                return 'Success';
        }

        return $this->render('register' , [
            'model' => $user
        ]);
    }
        $this->setLayout('auth');
           return $this->render('register' , [
            'model' => $user
        ]);
    }
    }
