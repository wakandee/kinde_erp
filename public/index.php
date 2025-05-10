<?php
//require_once __DIR__ . '/../vendor/autoload.php'; // If using composer
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Router.php';

use Core\Router;

$router = new Router();
$router->dispatch($_GET['url'] ?? '');

var_dump($_GET['url'] ?? ''); exit;


?>