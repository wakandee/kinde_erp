<?php

namespace App\Core;

class Router
{
    private $routes = [];

    // Non-static method for GET route registration
    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    // Non-static method for POST route registration
    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    // Method to dispatch the URL
    public function dispatch($url)
    {
        $url = trim($url, '/');  // Clean the URL
        $url = $url !== '' ? explode('/', $url) : [];  // Split the URL into segments

        $controllerName = isset($url[0]) && $url[0] !== '' ? ucfirst($url[0]) . 'Controller' : 'HomeController';
        $method = $url[1] ?? 'index';
        $params = array_slice($url, 2);

        // Determine the controller's class and file path
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
                    echo "404 - Method '$method' not found in controller '$controllerClass'.";
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
