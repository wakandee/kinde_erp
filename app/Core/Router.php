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
     * Dispatch the request based solely on the URL passed in from index.php.
     * 
     * @param string $uriArg  The value of $_GET['url'] (e.g. "departments")
     */
    public function dispatch(string $uriArg): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        // Normalize the incoming URI (strip slashes, ensure leading slash)
        $uri = $this->normalize('/' . ($uriArg ?: ''));

        // Match route
        $action = $this->routes[$method][$uri] ?? null;

        if (! $action) {
            http_response_code(404);
            echo "404 - Route {$uri} not found.";
            return;
        }

        // Parse controller and method
        [$controllerName, $methodName] = explode('@', $action, 2);
        $controllerClass = "App\\Controllers\\{$controllerName}";

        if (! class_exists($controllerClass)) {
            http_response_code(500);
            echo "Controller {$controllerClass} not found.";
            return;
        }

        $controller = new $controllerClass();

        if (! method_exists($controller, $methodName)) {
            http_response_code(500);
            echo "Method {$methodName} not found in {$controllerClass}.";
            return;
        }

        // Call the method (no parameters for now)
        $controller->{$methodName}();
    }

    /**
     * Normalize a URI: remove trailing slash, ensure leading slash.
     */
    private function normalize(string $uri): string
    {
        $uri = '/' . ltrim($uri, '/');
        return rtrim($uri, '/');
    }
}
