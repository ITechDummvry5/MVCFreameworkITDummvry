<?php 

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\models\User;


class LoginForm extends Model{

public string $email = '';
public string $password = '';

 public function rules():array{
    return [ 
        'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
        'password' => [self::RULE_REQUIRED]
    ];
 }

 //method for authcontroller
 public function login(){
    // this creates an instance of the User class
// $userModel = new User();
// $user = $userModel->findOne(['email' => $this->email]);
$user = User::findOne(['email' => $this->email]);
    if (!$user) {
      $this->addError('email','User not found');
      return false;
    }
    if (!password_verify($this->password, $user->password)) {
        $this->addError('password', 'Incorrect password');
        return false;
    }
    return Application::$app->login($user);
 }

     public function labels() : array {
        return [
            'email' => 'Email Address',
            'password' => 'User Password'
        ];
    }

}
