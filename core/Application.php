<?php

namespace app\core;

/**
 * @author: CarmillaIT 
 * @package: app\core
 */
class Application {

    public Router $router;
    public Request $request;

    public function __construct() {
        // [1] Create a new Request object to handle current HTTP request
        $this->request = new Request();

        // [2] Create a Router and inject the Request (dependency injection)
        $this->router = new Router($this->request);
    }

    public function run() {
        // [3] Resolve the current route and echo the response
        echo $this->router->resolve();
    }
}
