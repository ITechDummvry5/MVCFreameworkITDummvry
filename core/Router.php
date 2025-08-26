<?php

namespace app\core;

use app\core\exception\NotFound;

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

    
    public function resolve() {
        $path = $this->request->getPath();        // e.g. `/contact`
        $method = $this->request->method();    // e.g. `get`
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
           throw new NotFound();
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if(is_array($callback)){
            /** @var Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
                     $callback[0] = $controller;
            foreach($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
   
        }
      
        return  call_user_func($callback, $this->request, $this->response);
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
            $layout = Application::$app->layout;
        if(Application::$app->controller){
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
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

