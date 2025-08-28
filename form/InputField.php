<?php 

namespace app\form;

use app\core\Model;

class InputField extends BaseField{ 

    public const TYPE_TEXT = 'text';
    public const TYPE_NUMBER = 'number';
    public const TYPE_PASSWORD = 'password';

    public string $type;


    public function __construct(Model $model, string $att){
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $att);
    }


public function passwordField(){
    $this->type = self::TYPE_PASSWORD;
    return $this;
}

public function renderInput(): string 
{
    return sprintf('  <input type="%s" class="form-control%s" name="%s" placeholder="Enter your %s" value="%s">',

       $this->type,
        $this->model->hasError($this->att) ? ' is-invalid' : '', // input class bootstrap
        $this->att,                          // name attribute
        $this->att,                          // placeholder
        $this->model->{$this->att} ?? '',    // value from model //
        );
}



}