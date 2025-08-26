<?php 

namespace app\core\exception;

class NotFound extends \Exception

{
    protected $message = 'Page not found';
    protected $code = 404;
}