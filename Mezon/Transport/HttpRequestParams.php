<?php
namespace Mezon\Transport;

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
    
    // TODO refactor it using mezon/request

    /**
     * Fetching auth token from headers
     *
     * @param array $headers
     *            Request headers
     * @return string Session id
     */
    protected function getSessionIdFromHeaders(array $headers)
    {
        $basicPrefix = 'Basic ';

        if (isset($headers['Authentication'])) {
            return str_replace($basicPrefix, '', $headers['Authentication']);
        } elseif (isset($headers['Authorization'])) {
            return str_replace($basicPrefix, '', $headers['Authorization']);
        } elseif (isset($headers['Cgi-Authorization'])) {
            return str_replace($basicPrefix, '', $headers['Cgi-Authorization']);
        }

        throw (new \Exception('Invalid session token', 2));
    }

    /**
     * Method returns list of the request's headers
     *
     * @return array Array of headers
     */
    protected function getHttpRequestHeaders(): array
    {
        $headers = [];

        if (function_exists('getallheaders')) {
            $headers = getallheaders();
        }

        return $headers === false ? [] : $headers;
    }

    /**
     * Method returns session id from HTTP header
     *
     * @return string Session id
     */
    protected function getSessionId()
    {
        $headers = $this->getHttpRequestHeaders();

        return $this->getSessionIdFromHeaders($headers);
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
        $headers = $this->getHttpRequestHeaders();

        $return = $default;

        if ($param == 'session_id') {
            $return = $this->getSessionId();
        } elseif ($this->getRouter()->hasParam($param)) {
            $return = $this->getRouter()->getParam($param);
        } elseif (isset($headers[$param])) {
            $return = $headers[$param];
        } elseif (isset($_POST[$param])) {
            $return = $_POST[$param];
        } elseif (isset($_GET[$param])) {
            $return = $_GET[$param];
        }

        return $return;
    }
}
