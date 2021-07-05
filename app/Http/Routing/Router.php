<?php

namespace App\Http\Routing;

use App\Http\Kernel;
use App\Controller\Pages\Error;
use App\Http\Routing\Request;
use App\Http\Routing\Response;

final class Router extends Kernel
{

    public static function run(): void
    {
        $route = self::getRoute();

        $routeMiddleware = !empty($route['middlewares']) ? $route['middlewares']: [];
        self::runMiddlewares($routeMiddleware);

        $params = isset($route['paramNames']) ? self::getParamsFromUri($route) : [];

        call_user_func_array($route['action'], $params);
    }

    /**
     * Runs all the middlewware the route has.
     *
     * @param array $middlewares
     */
    private static function runMiddlewares(array $middlewares = []): void
    {
        foreach (parent::$globalMiddlewares as $middleware) {
            $realMiddleware = parent::$middlewaresList[$middleware];
            (new $realMiddleware)->run();
        }

        if (!empty($middlewares)) {
            foreach ($middlewares as $middleware) {
                $realMiddleware = parent::$middlewaresList[$middleware];
                (new $realMiddleware)->run();
            }
        }
    }

    /**
     * Matches the param values passed through the URI with their names in the route.
     * @param string $pattern
     * @param array $paramNames
     * @return array
     */
    private static function getParamsFromUri(array $route): array
    {
        $uri = Request::getUri();

        preg_match($route['pattern'], $uri, $paramValues);
        unset($paramValues[0]);
        $params = array_combine($route['paramNames'], $paramValues);

        $routeActionReflection = new \ReflectionFunction($route['action']);

        // Matches the params with their order in the function
        foreach ($routeActionReflection->getParameters() as $param) {
            $paramName = $param->getName();
            $args[$paramName] = $params[$paramName] ?? '';
        }

        return $args;
    }

    /**
     * Returns the current route information if matched.
     * @return array
     */
    private static function getRoute(): array
    {
        $requestUri = Request::getUri();
        $requestHttpMethod = Request::getHttpMethod();

        foreach (parent::$routes as $route => $methods) {
            if (preg_match($route, $requestUri)) {
                if (isset($methods[$requestHttpMethod])) {
                    return array_merge(['pattern' => $route], $methods[$requestHttpMethod]);
                }

                Response::send(Error::notFound(), 405); // Request method not found.
                exit;
            }
        }

        Response::send(Error::notFound(), 404); // Page not found.
        exit;
    }

    public static function redirect(string $to): void
    {
        http_response_code(301);
        header('Location: ' . DOMAIN . $to);
    }
}
