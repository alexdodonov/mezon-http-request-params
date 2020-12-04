<?php
namespace Mezon\Transport;

use Mezon\Router\Router;

/**
 * Class Request
 *
 * @package Transport
 * @subpackage HttpRequestParams
 * @author Dodonov A.A.
 * @version v.1.0 (2020/05/26)
 * @copyright Copyright (c) 2020, aeon.org
 */

/**
 * GLobal request data
 */
class Request
{

    /**
     * Global router
     *
     * @var Router
     */
    private static $globalRouter = null;

    /**
     * Stored request param
     *
     * @var HttpRequestParams
     */
    private static $httpRequestParams = null;

    /**
     * Method returns instance of HttpRequestParams and creates it if necessary
     *
     * @return HttpRequestParams
     */
    private static function getRequestParams(): HttpRequestParams
    {
        if (self::$httpRequestParams === null) {
            self::$httpRequestParams = new HttpRequestParams(self::$globalRouter);
        }

        return self::$httpRequestParams;
    }

    /**
     * Method registers router
     *
     * @param Router $router
     *            router
     */
    public static function registerRouter(Router &$router): void
    {
        self::$globalRouter = $router;
    }

    /**
     * Method hashes checkbox state
     *
     * @param string $fieldName
     *            field name
     * @param array $vars
     *            check box values
     * @return mixed hash item
     */
    public static function getChecked(string $fieldName, array $vars)
    {
        if (self::getRequestParams()->getParam($fieldName, false) !== false) {
            // something was submitted
            return $vars[0];
        }

        return $vars[1];
    }

    /**
     * Method returns request parameter
     *
     * @param string $param
     *            parameter name
     * @param mixed $default
     *            default value
     * @return mixed Parameter value
     * @codeCoverageIgnore
     */
    public static function getParam($param, $default = false)
    {
        return self::getRequestParams()->getParam($param, $default);
    }
}
