<?php
namespace Mezon\Transport\Tests;

class Headers
{
//TODO remove it. Use Headers\Layer from mezon/ifrastructure-layer
    /**
     * Request headers
     *
     * @var array
     */
    private static $testHeaders = [];

    /**
     * Method returns list of headers
     *
     * @return array list of headers
     */
    public static function getAllHeaders(): array
    {
        return self::$testHeaders;
    }

    /**
     * Method sets headers for testing purposes
     *
     * @param array $headers
     *            headers
     */
    public static function setAllHeaders(array $headers): void
    {
        self::$testHeaders = $headers;
    }
}
