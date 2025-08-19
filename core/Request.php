<?php 
namespace app\core;

class Request {

    // [1] Return the requested path without the query string
    public function getPath(){
        $path = $_SERVER['REQUEST_URI'] ?? '/'; // e.g. `/contact?lang=en`
        $position = strpos($path, '?');

        if ($position === false){
            return $path; // no query string
        }

        return substr($path, 0, $position); // cut off the query string

    }

    // [2] Return the request method in lowercase (get/post)
    public function method(){
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    
    // [2] Return the request method in lowercase (get/post)
    public function isGet(){
        return $this->method() === 'get';
    }    
    // [2] Return the request method in lowercase (get/post)
    public function isPost(){
           return $this->method() === 'post';

    }


    public function getBody(){
        $body = [];
        if($this->isGet()){
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }    
        if($this->isPost()){
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}
