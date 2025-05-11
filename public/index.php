<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use App\Core\Router;

$router = new Router();
require_once __DIR__ . '/../routes/web.php';

$router->dispatch($_GET['url'] ?? '');

exit;
