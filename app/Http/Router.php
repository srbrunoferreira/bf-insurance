<?php

namespace App\Http;

use Closure;
use Exception;

final class Router
{
    /**
     * Stores the routes.
     * @var array
     */
    public static array $routes;

    /**
     * Stores a instance of Resquest class.
     * @var Request
     */
    private static Request $request;

    /**
     * Replaces the __constructor function.
     */
    public static function init(): void
    {
        self::$request = new Request();
    }

    public static function run(): void
    {
        $route = self::getRoute();
        $args = isset($route['params']) ? self::getParams($route['pattern'], $route['params']) : [];

        call_user_func_array($route['action'], $args);
    }

    /**
     * Matches the param values passed through the URI with their names in the route.
     * @param string $pattern
     * @param array $paramNames
     * @return array
     */
    public static function getParams(string $pattern, array $paramNames): array
    {
        $uri = self::$request->getUri();

        preg_match($pattern, $uri, $matches);
        unset($matches[0]);
        $paramsValues = $matches;

        $params = array_combine($paramNames, $paramsValues);

        return $params;
    }

    /**
     * Returns the current route information if matched.
     * @return array
     */
    public static function getRoute(): array
    {
        $requestUri = self::$request->getUri();
        $requestHttpMethod = self::$request->getHttpMethod();

        foreach (self::$routes as $route => $methods) {
            if (preg_match($route, $requestUri)) {
                if (isset($methods[$requestHttpMethod])) {
                    return array_merge(['pattern' => $route], $methods[$requestHttpMethod]);
                }
                throw new Exception('Método não é permitido', 405);
            }
        }
        throw new Exception("URL não encontrada.", 404);
    }

    /**
     * Generic method that insert the routes into the system.
     * @param string $httpMethod
     * @param string $route
     * @param \Closure $action
     */
    private static function addRoute(string $httpMethod, string $route, \Closure $action): void
    {
        $routeVarPattern = '/{.*?}/';

        // Checks if there are variables that will pass through the route.
        // Checks if exists any {string} in the $route string.
        if (preg_match_all($routeVarPattern, $route, $matches)) {
            $matches = array_values($matches[0]);
            $route = str_replace($matches, '(\S*?)', $route);
            $params = str_replace(['{', '}'], '', $matches);
        }

        // Converts the route to it's regex pattern.
        $route = '/^' . str_replace('/', '\/', $route) . '$/';

        self::$routes[$route][$httpMethod]['action'] = $action;
        if (isset($params)) {
            self::$routes[$route][$httpMethod]['params'] = $params;
        }
    }

    /**
     * Retreive resources.
     * @param string $route
     * @param \Closure $action
     */
    public static function get(string $route, \Closure $action): void
    {
        self::addRoute('GET', $route, $action);
    }

    /**
     * Update resources.
     * @param string $route
     * @param \Closure $action
     */
    public static function put(string $route, \Closure $action): void
    {
        self::addRoute('PUT', $route, $action);
    }

    /**
     * Create resources.
     * @param string $route
     * @param \Closure $action
     */
    public static function post(string $route, \Closure $action): void
    {
        self::addRoute('POST', $route, $action);
    }

    /**
     * Delete resources.
     * @param string $route
     * @param \Closure $action
     */
    public static function delete(string $route, \Closure $action): void
    {
        self::addRoute('DELETE', $route, $action);
    }
}
