<?php 

namespace app\form;

use app\core\Model;


abstract class BaseField{

abstract public function renderInput(): string;

    public Model $model;
    public string $att;

    public function __construct(Model $model, string $att){
        $this->model = $model;
        $this->att = $att;
    }


public function __toString(): string {
    return sprintf('
    <div class="mb-3">
        <label for="%s" class="form-label">%s</label>
        %s
        <div class="invalid-feedback">%s</div>
    </div>
    ',
        $this->att,                          // for attribute in label
        $this->model->labels()[$this->att] ?? ucfirst($this->att),  // FOR THE lOGIN.PHP
        $this->renderInput(),               // input field
        $this->model->getFirstError($this->att) // invalid-feedback
    );
}

}