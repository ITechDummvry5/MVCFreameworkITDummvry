<?php 

namespace app\form;


class TextAreaField extends BaseField{

public function renderInput(): string 
{
    return sprintf('  <textarea class="form-control%s" name="%s" placeholder="Enter your %s">%s</textarea>',

        $this->model->hasError($this->att) ? ' is-invalid' : '', // input class bootstrap
        $this->att,                          // name attribute
        $this->att,                          // placeholder
        $this->model->{$this->att} ?? '',    // value from model //
        );

}
}
// for text area field