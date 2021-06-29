<?php

namespace App\Http;

use App\Controller\Pages\Error;
use App\Http\Routing\Request;
use App\Http\Routing\Response;

abstract class Kernel
{
    /**
     * Stores the routes of the system.
     */
    protected static array $routes;

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
            self::$routes[$route][$httpMethod]['paramNames'] = $params;
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
