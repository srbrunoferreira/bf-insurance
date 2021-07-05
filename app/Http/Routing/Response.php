<?php

namespace App\Http\Routing;

final class Response
{
    /**
     * @var array
     */
    private static array $headers;

    /**
     * @var int
     */
    private static int $httpCode;

    /**
     * @var string
     */
    private static string $contentType;

    /**
     * @var mixed
     */
    private static $content;

    /**
     * Defines the httpCode, the content and the contentType of the response.
     * @param $content
     * @param int $httpCode
     * @param string $contentType
     */
    public static function send($content, int $httpCode = 200, string $contentType = 'text/html'): void
    {
        self::$httpCode = $httpCode;
        self::$content = $content;
        self::setContentType($contentType);

        self::sendHeaders();
        echo self::$content;
    }

    /**
     * Defines the response's Content-Type and then sets it to the response's header.
     * @param string $contentType
     */
    private static function setContentType(string $contentType): void
    {
        self::$contentType = $contentType;
        self::addHeader('Content-Type', $contentType);
    }

    /**
     * Sets a key and its value to the response's header.
     * @param string $key
     * @param string $value
     */
    private static function addHeader(string $key, string $value): void
    {
        self::$headers[$key] = $value;
    }

    /**
     * Sends the headers of the response.
     */
    private static function sendHeaders(): void
    {
        http_response_code(self::$httpCode);

        foreach (self::$headers as $key => $value) {
            header($key . ':' . $value);
        }
    }
}
