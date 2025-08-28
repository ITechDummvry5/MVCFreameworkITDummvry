<?php 

namespace app\form;

use app\core\Model;
use app\form\InputField;   // ✅ add this line


class Form{
    public static function begin($action, $method){
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end(){
        echo '</form>';
    }
    public function field(Model $model, $att){
        return new InputField($model, $att);
    }
    // public function passfield(){
        
    // }
}
