<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    /**
     * Register a GET route.
     */
    public function get(string $uri, string $action): void
    {
        $this->routes['GET'][$this->normalize($uri)] = $action;
    }

    /**
     * Register a POST route.
     */
    public function post(string $uri, string $action): void
    {
        $this->routes['POST'][$this->normalize($uri)] = $action;
    }

    /**
     * Dispatch the request based on the normalized URI,
     * supporting both static and dynamic routes (e.g., /resource/{id}).
     *
     * @param string $uriArg The value of $_GET['url'] (e.g. "departments" or "designations/by-department/2")
     */
    public function dispatch(string $uriArg): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->normalize('/' . ($uriArg ?: ''));

        // First check for an exact match
        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];
            [$controllerName, $methodName] = explode('@', $action);
            $this->invokeController($controllerName, $methodName);
            return;
        }

        // If no exact match, check for dynamic route patterns
        foreach ($this->routes[$method] as $route => $action) {
            // Convert route pattern (e.g. /designations/by-department/{id}) to regex
            $routePattern = preg_replace('#\{[\w]+\}#', '([\w-]+)', $route);
            $routeRegex = "#^" . $routePattern . "$#";

            // Attempt to match the URI to the pattern
            if (preg_match($routeRegex, $uri, $matches)) {
                array_shift($matches); // Remove full match
                [$controllerName, $methodName] = explode('@', $action);
                $this->invokeController($controllerName, $methodName, $matches);
                return;
            }
        }

        // No route matched
        http_response_code(404);
        echo "404 - Route {$uri} not found.";
    }

    /**
     * Helper to call a controller method with optional parameters.
     *
     * @param string $controllerName Controller class (e.g. "DepartmentController")
     * @param string $methodName Method to invoke on the controller
     * @param array $params Parameters extracted from the URI (if any)
     */
    private function invokeController(string $controllerName, string $methodName, array $params = []): void
    {
        $controllerClass = "App\\Controllers\\{$controllerName}";

        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo "Controller {$controllerClass} not found.";
            return;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $methodName)) {
            http_response_code(500);
            echo "Method {$methodName} not found in {$controllerClass}.";
            return;
        }

        // Call the controller method, passing any URI parameters
        call_user_func_array([$controller, $methodName], $params);
    }

    /**
     * Normalize a URI: ensure leading slash, remove trailing slash.
     */
    private function normalize(string $uri): string
    {
        $uri = '/' . ltrim($uri, '/');
        return rtrim($uri, '/');
    }
}
