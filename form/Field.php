<?php 

namespace app\form;

use app\core\Model;

class Field{

    public const TYPE_TEXT = 'text';
    public const TYPE_NUMBER = 'number';
    public const TYPE_PASSWORD = 'password';

    public string $type;
    public Model $model;
    public string $att;

    public function __construct(Model $model, string $att){
        $this->type = 'text';
        $this->model = $model;
        $this->att = $att;
    }

public function __toString(): string {
    return sprintf('
    <div class="mb-3">
        <label for="%s" class="form-label">%s</label>
        <input type="%s" class="form-control%s" name="%s" placeholder="Enter your %s" value="%s">
        <div class="invalid-feedback">%s</div>
    </div>
    ',
        $this->att,                          // for attribute in label
        $this->model->labels()[$this->att] ?? ucfirst($this->att),  // FOR THE lOGIN.PHP INPUTS
        $this->type,
        $this->model->hasError($this->att) ? ' is-invalid' : '', // input class
        $this->att,                          // name attribute
        $this->att,                          // placeholder
        $this->model->{$this->att} ?? '',    // value from model
        $this->model->getFirstError($this->att) // invalid-feedback
    );
}
public function passwordField(){
    $this->type = self::TYPE_PASSWORD;
    return $this;
}



}