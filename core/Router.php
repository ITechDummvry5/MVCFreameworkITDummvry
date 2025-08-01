<?php

namespace app\core;

class Router {

    public Request $request;
    protected array $routes = [];

    /**
     * @param \app\core\Request $request
     */
    public function __construct(\app\core\Request $request) {
        // [1] Save the incoming Request object
        $this->request = $request;
    }

    // [2] Register a GET route and store the callback
    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    // [3] Find and execute the appropriate callback for the current route
    public function resolve() {
        $path = $this->request->getPath();        // e.g. `/contact`
        $method = $this->request->getMethod();    // e.g. `get`

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            // [4] Route not found
            http_response_code(404);
            return "404 Not Found";
        }

        if (is_callable($callback)) {
            // [5] If the callback is a function, call it
            return call_user_func($callback);
        }

        // [6] If not a valid callback
        return "Invalid route callback.";
    }
}

// Simple Version of resolve method 
//   public function resolve() {

//         $path = $this->request->getPath();
//         $method = $this->request->getMethod();
//         $callback = $this->routes[$method][$path] ?? false;

//         if ($callback === false) {
//             http_response_code(404);
//             return "404 Not Found";
//         }
//         echo call_user_func($callback);
//     }

