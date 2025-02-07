<?php

namespace Core;
class Router
{
    public static function route(): void
    {
        require BASE_PATH . '/routes/web.php';

        $request = trim($_SERVER['PATH_INFO']);
        if (array_key_exists($request, ROUTES)) {
            $controller = ROUTES[$request][0];
            $method = ROUTES[$request][1];

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
