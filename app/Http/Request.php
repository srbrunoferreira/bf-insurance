<?php

namespace App\Http;

final class Request
{
    /**
     * Stores the current request URI.
     * @var string
     */
    private static string $uri;

    /**
     * Stores the current request HTTP method.
     * @var string
     */
    private static string $httpMethod;

    public function __construct()
    {
        self::$uri = $_SERVER['REQUEST_URI'];
        self::$httpMethod = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Return the request URI.
     * @return string
     */
    public static function getUri(): string
    {
        return self::$uri;
    }

    /**
     * Returns the request HTTP method.
     * @return string
     */
    public static function getHttpMethod(): string
    {
        return self::$httpMethod;
    }
}
