<?php
namespace App\Core;

class Router {
    public function dispatch($url) {
        $url = trim($url, '/');
        $url = $url !== '' ? explode('/', $url) : [];

        $controllerName = isset($url[0]) && $url[0] !== '' ? ucfirst($url[0]) . 'Controller' : 'HomeController';
        $method = $url[1] ?? 'index';
        $params = array_slice($url, 2);

        $controllerClass = "App\\Controllers\\$controllerName";
        $controllerPath = __DIR__ . "/../Controllers/$controllerName.php";

        if (file_exists($controllerPath)) {
            require_once $controllerPath;

            if (class_exists($controllerClass)) {
                $controllerObj = new $controllerClass();

                if (method_exists($controllerObj, $method)) {
                    call_user_func_array([$controllerObj, $method], $params);
                    return;
                } else {
                    http_response_code(404);
                    echo "404 - Method '$method' not found in controller '$controllerClass'";
                    return;
                }
            } else {
                http_response_code(404);
                echo "404 - Controller class '$controllerClass' not found.";
                return;
            }
        } else {
            http_response_code(404);
            echo "404 - Controller file '$controllerPath' not found.";
            return;
        }
    }
}
