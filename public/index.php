<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use App\Core\Router;

$router = new Router();
$router->dispatch($_GET['url'] ?? '');

exit;
