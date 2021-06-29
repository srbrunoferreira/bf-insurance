<?php

namespace App\Http\Routing;

final class Request
{
    /**
     * Return the request URI.
     * @return string
     */
    public static function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = strpos($uri, 'api')? rtrim($uri, '/') : $uri;
        $uri = explode('?', $uri)[0];

        return $uri;
    }

    /**
     * Returns the request HTTP method.
     * @return string
     */
    public static function getHttpMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Return the complete url that appears in the browser.
     * @return string
     */
    public static function getCompleteUrl(): string
    {
        return $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    }
}
