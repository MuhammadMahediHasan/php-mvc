<?php

namespace Core;
class Router
{
    public static function route()
    {
        require BASE_PATH . '/routes/web.php';

        $request = trim($_SERVER['REQUEST_URI']);

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
    }
}
