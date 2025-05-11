<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use App\Core\Router;

// Instantiate the Router class
$router = new Router();

// Include the routes file
require_once __DIR__ . '/../routes/web.php';  // This file will use the existing $router instance

// Dispatch the request
$url = $_GET['url'] ?? '';  // Fetch the URL from the query string
$router->dispatch($url);  // Dispatch the URL

exit;
