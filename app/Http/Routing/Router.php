<?php

namespace App\Http\Routing;

use App\Http\Kernel;
use App\Http\Routing\Request;
use App\Http\Middleware\ApiAuth;
use App\Controller\Pages\Error;
use App\Http\Routing\Response;

final class Router extends Kernel
{
    /**
     * Stores the routes.
     * @var array
     */
    public static array $routes;

    /**
     * Stores the middlewares.
     * @var array
     */
    private static array $middlewares;

    /**
     * Stores the host domain.
     * @var string
     */
    private static string $host;

    private function init(): void
    {
        self::$host = $_SERVER['HTTPS'] ? 'https://' : 'http://';
        self::$host .= $_SERVER['HTTP_HOST'];
    }

    public static function run(): void
    {
        self::init();
        $route = self::getRoute();
        $params = isset($route['paramNames']) ? self::getParams($route) : [];

        call_user_func_array($route['action'], $params);
    }

    /**
     * Matches the param values passed through the URI with their names in the route.
     * @param string $pattern
     * @param array $paramNames
     * @return array
     */
    public static function getParams(array $route): array
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
    public static function getRoute(): array
    {
        $requestUri = Request::getUri();
        $requestHttpMethod = Request::getHttpMethod();

        foreach (self::$routes as $route => $methods) {
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

    /**
     *
     */
    public static function middleware(): void
    {
        // return self;
    }

    public static function redirect(string $to): void
    {
        http_response_code(301);
        header('Location: ' . self::$host . $to);
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
