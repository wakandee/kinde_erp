<?php
namespace Core;

class Router {
    public function dispatch($url) {
        $url = trim($url, '/');
        $url = $url !== '' ? explode('/', $url) : [];

        $controllerName = isset($url[0]) && $url[0] !== '' ? ucfirst($url[0]) . 'Controller' : 'HomeController';
        $method = $url[1] ?? 'index';
        $params = array_slice($url, 2);

        $controllerPath = __DIR__ . "/../app/controllers/$controllerName.php";
        if (file_exists($controllerPath)) {
            require_once $controllerPath;

            if (class_exists($controllerName)) {
                $controllerObj = new $controllerName();

                if (method_exists($controllerObj, $method)) {
                    call_user_func_array([$controllerObj, $method], $params);
                    return;
                } else {
                    http_response_code(404);
                    echo "404 - Method '$method' not found in controller '$controllerName'";
                    return;
                }
            } else {
                http_response_code(404);
                echo "404 - Class '$controllerName' not defined in $controllerPath";
                return;
            }
        }

        http_response_code(404);
    }
}

 ?>