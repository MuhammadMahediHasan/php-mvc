<?php

namespace Core;
class Router
{
    public static function route(): void
    {
        require BASE_PATH . '/routes/web.php';
        $requestUri = trim($_SERVER['PATH_INFO'] ?? '/');
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset(ROUTES[$requestUri][$requestMethod])) {
            $controller = ROUTES[$requestUri][$requestMethod][0];
            $method = ROUTES[$requestUri][$requestMethod][1];

            if (class_exists($controller)) {
                $class = new $controller();
                if (method_exists($controller, $method)) {
                    $class->$method();
                    exit;
                }
            }
        }

        http_response_code(HTTP_NOT_FOUND);
        include view('errors/404.php');
    }
}
