<?php
namespace Mezon\Transport;

use Mezon\Router\Router;

/**
 * Class HttpRequestParams
 *
 * @package Transport
 * @subpackage HttpRequestParams
 * @author Dodonov A.A.
 * @version v.1.0 (2020/05/26)
 * @copyright Copyright (c) 2020, aeon.org
 */

/**
 * Request params fetcher
 */
class HttpRequestParams extends RequestParams
{

    /**
     * Constructor
     *
     * @param Router $router
     *            Router object
     */
    public function __construct(Router &$router)
    {
        $this->router = $router;

        Request::registerRouter($this->router);
    }

    /**
     * Method returns request parameter
     *
     * @param string $param
     *            parameter name
     * @param mixed $default
     *            default value
     * @return mixed Parameter value
     */
    public function getParam($param, $default = false)
    {
        return Request::getParam($param, $default);
    }
}
