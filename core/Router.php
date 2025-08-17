<?php

namespace app\core;

class Router {

    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * @param \app\core\Request $request
     * @package \app\core
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

    // [2] Register a post route and store the callback
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
            return $this->renderView("_404");
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if(is_array($callback)){
            $callback[0]= new $callback[0]();
        }
        // [6] If not a valid callback
        return  call_user_func($callback);
    }
    
    
    public function renderView($view, $params = []){
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent );
    }

        
    public function renderContent($viewContent){
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent );
    }

    protected function layoutContent(){
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/main.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params = []){
        foreach($params as $key => $value){
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

    

}

