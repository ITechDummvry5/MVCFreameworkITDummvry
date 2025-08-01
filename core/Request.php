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

        // (this part below is unreachable and can be removed)
        echo '<pre>';
        var_dump($position);
        echo '<pre>';
        exit;
    }

    // [2] Return the request method in lowercase (get/post)
    public function getMethod(){
        return strtolower($_SERVER['REQUEST_METHOD'] ?? 'get');
    }
}
