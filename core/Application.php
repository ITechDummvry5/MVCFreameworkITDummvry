<?php

namespace app\core;


/**
 * @author: CarmillaIT 
 * @package: app\core
 */
class Application {

    public string $userClass;


    public string $layout = 'main';
    
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public ?Controller $controller = null;
    public Database $db;
    public View $view;
    public Session $session;
    public ?DbModel $user; // chatgpt public ?User $user;
// chatgpt public ?Controller $controller = null;
    public static Application $app;


    // public function __construct($rootPath)
    public function __construct($rootPath , array $config)
    {
        $this->userClass = $config['userClass'];
        
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
        $this->view = new View();

        //access user without not directly   using in the publicfolder index
        $primaryValue = $this->session->get('user');
        if($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        }else{
            $this->user = null;
        }

    }

public function run()
{
    try {
        echo $this->router->resolve();
    } catch (\Exception $e) {
        $this->response->setStatusCode($e->getCode() ?: 500);
        echo $this->view->renderView('_error', [
            'exception' => $e
        ]);
    }
}


    public function getController(){
        return $this->controller;
    }
    public function setController(Controller $controller){
        $this->controller = $controller;
    }
    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

        public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
        return true;
    }
    public static function isGuest()
    {
        return !self::$app->user;
    }
}





