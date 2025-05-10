<?php
namespace Core;

class Router {
    public function dispatch($url) {
        $url = explode('/', trim($url, '/'));
        $controller = ucfirst($url[0] ?? 'Home') . 'Controller';
        $method = $url[1] ?? 'index';
        $params = array_slice($url, 2);

        $controllerPath = "../app/controllers/$controller.php";
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $controllerObj = new $controller();
            if (method_exists($controllerObj, $method)) {
                call_user_func_array([$controllerObj, $method], $params);
                return;
            }
        }
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}
