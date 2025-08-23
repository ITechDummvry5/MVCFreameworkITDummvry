<?php

namespace app\controllers;   // 👈 add this so Router can find it

use app\core\Application;
use app\core\Controller;   // 👈 now PHP knows where to find Controller
use app\core\Request;
use app\models\User;  // 👈 import the User Model class clear
use app\models\LoginForm;
use app\core\Response;


class AuthController extends Controller{
    public function login(Request $request, Response $response){
        $loginForm = new LoginForm();

        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()) {
              $response->redirect('/');
              return;
            }
        }
        
        $this->setLayout('auth');
        
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }
    // Registerd new User in Db using model User and DbModel
        public function register(Request $request){
        $user = new User();
        if($request->isPost()){

            $user->loadData($request->getBody());


            if($user->validate() && $user->registered()) { 
            Application::$app->session->setflash_message('success', 'Thanks for registering!');
              Application::$app->response->redirect('/');
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
