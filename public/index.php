<?php

// [1] Autoload all classes using Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use app\core\Application;

// [2] Instantiate the main Application class (bootstraps app)
$app = new Application();

/**
 * @author: CarmillaIT 
 * @package: app\core
 */

// [3] Define a route for `/` with a closure that returns a string
$app->router->get('/', function(){
    return 'Hello, World!';
});

// [4] Define another route for `/contact`
$app->router->get('/contact', function(){
    return 'Hello, World! Contact Page';
});

// [5] Start the app and route resolution
$app->run();
