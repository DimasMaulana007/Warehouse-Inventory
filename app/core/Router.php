<?php
class Router {
    protected $routes = [];

    public function get($uri, $controllerAction) {
        $this->routes['GET'][$uri] = $controllerAction;
    }

    public function post($uri, $controllerAction) {
        $this->routes['POST'][$uri] = $controllerAction;
    }

    public function dispatch($uri, $method) {
        $routeParam = isset($_GET['route']) ? '/' . $_GET['route'] : '/';

        if (isset($this->routes[$method][$routeParam])) {
            $action = $this->routes[$method][$routeParam];
            $parts = explode('@', $action);
            $controllerName = $parts[0];
            $methodName = $parts[1];

            require_once "../app/Controllers/{$controllerName}.php";
            $controller = new $controllerName();
            $controller->$methodName();
        } else {
            http_response_code(404);
            echo "<h2>404 Not Found</h2><p>The route '{$routeParam}' could not be found.</p>";
        }
    }
}
?>
