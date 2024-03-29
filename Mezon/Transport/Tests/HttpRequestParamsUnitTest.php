<?php
namespace Mezon\Transport\Tests;

use Mezon\Router\Router;
use PHPUnit\Framework\TestCase;
use Mezon\Transport\HttpRequestParams;
use Mezon\Headers\Layer;
use Mezon\Conf\Conf;

/**
 * Unit tests for the class HttpRequestParams
 */
// TODO do we need this crap?
define('SESSION_ID_FIELD_NAME', 'session_id');

/**
 *
 * @author Dodonov A.A.
 * @psalm-suppress PropertyNotSetInConstructor
 */
class HttpRequestParamsUnitTest extends TestCase
{

    /**
     *
     * {@inheritdoc}
     * @see TestCase::setUp()
     */
    protected function setUp(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        Conf::setConfigStringValue('headers/layer', 'mock');
    }

    /**
     * Method constructs object to be tested
     *
     * @return HttpRequestParams request param object
     */
    protected function getRequestParamsMock(): HttpRequestParams
    {
        $router = new Router();
        $router->addRoute('/test/[i:rparam]/', function () {
            // no need to do something
        }, 'GET');
        $router->callRoute('/test/111/');

        return new HttpRequestParams($router);
    }

    /**
     * Testing empty result of the getHttpRequestHeaders method
     */
    public function testGetHttpRequestHeaders(): void
    {
        // setup
        $requestParams = $this->getRequestParamsMock();

        // test body
        /** @var string $param */
        $param = $requestParams->getParam('unexisting-param', 'default-value');

        // assertions
        $this->assertEquals('default-value', $param, 'Default value must be returned but it was not');
    }

    /**
     * Testing getting parameter
     */
    public function testGetSessionIdFromAuthorization(): void
    {
        // setup
        Layer::setAllHeaders([
            'Authorization' => 'Basic author session id'
        ]);
        $requestParams = $this->getRequestParamsMock();

        // test body
        /** @var string $param */
        $param = $requestParams->getParam(SESSION_ID_FIELD_NAME);

        // assertions
        $this->assertEquals('author session id', $param);
    }

    /**
     * Testing getting parameter
     */
    public function testGetSessionIdFromAuthentication(): void
    {
        // setup
        Layer::setAllHeaders([
            'Authentication' => 'Basic author session id'
        ]);
        $requestParams = $this->getRequestParamsMock();

        // test body
        /** @var string $param */
        $param = $requestParams->getParam(SESSION_ID_FIELD_NAME);

        // assertions
        $this->assertEquals('author session id', $param, 'Session id must be fetched but it was not');
    }

    /**
     * Testing getting parameter
     */
    public function testGetSessionIdFromCgiAuthorization(): void
    {
        // setup
        Layer::setAllHeaders([
            'Cgi-Authorization' => 'Basic cgi author session id'
        ]);
        $requestParams = $this->getRequestParamsMock();

        // test body
        /** @var string $param */
        $param = $requestParams->getParam(SESSION_ID_FIELD_NAME);

        // assertions
        $this->assertEquals('cgi author session id', $param, 'Session id must be fetched but it was not');
    }

    /**
     * Testing getting parameter
     */
    public function testGetUnexistingSessionId(): void
    {
        Layer::setAllHeaders([]);

        $requestParams = $this->getRequestParamsMock();

        $this->expectException(\Exception::class);
        $requestParams->getParam(SESSION_ID_FIELD_NAME);
    }

    /**
     * Testing getting parameter from custom header
     */
    public function testGetParameterFromHeader(): void
    {
        // setup
        Layer::setAllHeaders([
            'Custom-Header' => 'header value'
        ]);

        $requestParams = $this->getRequestParamsMock();

        // test body
        /** @var string $param */
        $param = $requestParams->getParam('Custom-Header');

        // assertions
        $this->assertEquals('header value', $param, 'Header value must be fetched but it was not');
    }

    /**
     * Testing getting parameter from $_POST
     */
    public function testGetParameterFromPost(): void
    {
        // setup
        $_POST['post-parameter'] = 'post value';

        $requestParams = $this->getRequestParamsMock();

        // test body
        /** @var string $param */
        $param = $requestParams->getParam('post-parameter');

        // assertions
        $this->assertEquals('post value', $param, 'Value from $_POST must be fetched but it was not');
    }

    /**
     * Testing getting parameter from $_GET
     */
    public function testGetParameterFromGet(): void
    {
        // setup
        $_GET['get-parameter'] = 'get value';

        $requestParams = $this->getRequestParamsMock();

        // test body
        /** @var string $param */
        $param = $requestParams->getParam('get-parameter');

        // assertions
        $this->assertEquals('get value', $param, 'Value from $_GET must be fetched but it was not');
    }

    /**
     * Testing method getParam wich fetches parameter from the route
     */
    public function testGettingParametersFromRoute(): void
    {
        // setup
        $requestParams = $this->getRequestParamsMock();

        // test body
        /** @var int $param */
        $param = $requestParams->getParam('rparam');

        // assertions
        $this->assertEquals(111, $param);
    }
}