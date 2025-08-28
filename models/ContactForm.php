<?php 

namespace app\models;

use app\core\Model;

class ContactForm extends Model{
    public string $name = '';
    public string $email = '';
    public string $subject = '';

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
        'subject' => [self::RULE_REQUIRED],
    ];
}

    public function labels(): array
    {
        return [
            'name' => 'Your Name',
            'email' => 'Your Email',
            'subject' => 'Subject',
        ];
    }
    
    
public function send(){
    return true;
}
}