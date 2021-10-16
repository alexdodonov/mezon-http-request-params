<?php
namespace Mezon\Transport\Tests;

class Headers
{

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
