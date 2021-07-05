<?php

namespace App\Http;

abstract class Kernel
{
    /**
     * Stores the routes of the system.
     */
    protected static array $routes;

    /**
     * Stores the middlewares with fliendly key name.
     */
    protected static array $middlewaresList = [
        'auth' => \App\Http\Middleware\Auth::class,
        'api.auth' => \App\Http\Middleware\ApiAuth::class
    ];

    /**
     * Stores the middlewares that are executed every request.
     */
    protected static array $globalMiddlewares = [];

    /**
     * Generic method that insert the routes into the system.
     * @param string $httpMethod
     * @param string $route
     * @param \Closure $action
     */
    private static function addRoute(string $httpMethod, string $route, \Closure $action, $middleware): void
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

        if (isset($params))
            self::$routes[$route][$httpMethod]['paramNames'] = $params;

        if (!empty($middleware))
            self::$routes[$route][$httpMethod]['middlewares'] = $middleware;
    }

    /**
     * Retreive resources.
     * @param string $route
     * @param \Closure $action
     */
    public static function get(string $route, \Closure $action, array $middleware = []): void
    {
        self::addRoute('GET', $route, $action, $middleware);
    }

    /**
     * Update resources.
     * @param string $route
     * @param \Closure $action
     */
    public static function put(string $route, \Closure $action, array $middleware = []): void
    {
        self::addRoute('PUT', $route, $action, $middleware);
    }

    /**
     * Create resources.
     * @param string $route
     * @param \Closure $action
     */
    public static function post(string $route, \Closure $action, array $middleware = []): void
    {
        self::addRoute('POST', $route, $action, $middleware);
    }

    /**
     * Delete resources.
     * @param string $route
     * @param \Closure $action
     */
    public static function delete(string $route, \Closure $action, array $middleware = []): void
    {
        self::addRoute('DELETE', $route, $action, $middleware);
    }
}
