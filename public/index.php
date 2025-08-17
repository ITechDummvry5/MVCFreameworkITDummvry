<?php

// [1] Autoload all classes using Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\SiteController;
use app\core\Application;

// [2] Instantiate the main Application class (bootstraps app)
$app = new Application(dirname(__DIR__));

/**
 * @author: CarmillaIT 
 * @package: app\core
 */

// [3] Define a route for `/` with a closure that returns a string
$app->router->get('/', [SiteController::class, 'home']);


// [4] Define another route for `/contact`
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handleContact']);


// [5] Start the app and route resolution
$app->run();
