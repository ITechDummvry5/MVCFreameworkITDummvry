<?php

namespace app\models;

use app\core\Model;

class RegisterModel extends Model   // 👈 extend Model here
{
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';

    public function register() {
       echo 'User registered successfully!';
    }

    public function rules(): array {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 30]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }
    public function labels() : array {
        return [
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Email Address',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password'
        ];
    }

}
