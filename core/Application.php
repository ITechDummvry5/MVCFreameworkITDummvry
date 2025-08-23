<?php

namespace app\core;


/**
 * @author: CarmillaIT 
 * @package: app\core
 */
class Application {
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Database $db;
    public Session $session;
// chatgpt public ?Controller $controller = null;
    public static Application $app;

    // public function __construct($rootPath)
    public function __construct($rootPath , array $config)
    {
        
        //[0] Set the root directory for the application because it is used to locate files layout and views and 
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        // [1] Create a new Request object to handle current HTTP request
        $this->request = new Request();

        // [3] Create a Response Object to handle http Responses  also make sure it first before the router 
        $this->response = new Response(); 

        // [2] Create a Router and inject the Request (dependency injection)
        $this->router = new Router($this->request, $this->response);

        // [4] Create a Session object message
        $this->session = new Session();

        // [5] Create a Database object
        $this->db = new Database($config['db']);


    }

    public function run() {
        // [3] Resolve the current route and echo the response
        echo $this->router->resolve();
        
    }
}
