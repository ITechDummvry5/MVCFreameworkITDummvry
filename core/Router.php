<?php

namespace app\core;

class Router {

    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * @param \app\core\Request $request
     * @param \app\core\Response $response
     */
    public function __construct(Request $request , Response $response) {
        // [1] Save the incoming Request object
        $this->request = $request;
        $this->response = $response;
    }

    // [2] Register a GET route and store the callback
    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    // [2] Register a GET route and store the callback
    public function post($path, $callback) {
        $this->routes['post'][$path] = $callback;
    }


    // [3] Find and execute the appropriate callback for the current route
    public function resolve() {
        $path = $this->request->getPath();        // e.g. `/contact`
        $method = $this->request->getMethod();    // e.g. `get`

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            // [4] Route not found
          $this->response->setStatusCode(404);
            return "Not Found";
        }

        // if (is_callable($callback)) {
        //     // [5] If the callback is a function, call it
        //     return call_user_func($callback);
        // }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        // [6] If not a valid callback
        return  call_user_func($callback);
    }
    
    public function renderView($view){
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view);
        return str_replace('{{content}}', $viewContent, $layoutContent );
    }

    protected function layoutContent(){
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/main.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view){
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

}

