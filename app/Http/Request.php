<?php

namespace App\Http;

final class Request
{
    /**
     * Return the request URI.
     * @return string
     */
    public static function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        return strpos($uri, 'api')? rtrim($uri, '/') : $uri;
    }

    /**
     * Returns the request HTTP method.
     * @return string
     */
    public static function getHttpMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
