<?php

namespace App\Http\Routing;

use App\Http\Kernel;
use App\Http\Routing\Request;
use App\Controller\Pages\Error;
use App\Http\Routing\Response;

final class Router extends Kernel
{

    public static function run(): void
    {
        $route = self::getRoute();
        $params = isset($route['paramNames']) ? self::getParamsFromUri($route) : [];

        call_user_func_array($route['action'], $params);
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
