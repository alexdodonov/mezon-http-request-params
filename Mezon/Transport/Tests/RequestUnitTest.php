<?php
use PHPUnit\Framework\TestCase;
use Mezon\Transport\Request;
use Mezon\Router\Router;
use Mezon\Conf\Conf;

/**
 *
 * @author Dodonov A.A.
 * @psalm-suppress PropertyNotSetInConstructor
 */
class RequestUnitTest extends TestCase
{

    /**
     *
     * {@inheritdoc}
     * @see TestCase::setUp()
     */
    protected function setUp(): void
    {
        // TODO move to the base class
        Conf::setConfigStringValue('headers/layer', 'mock');
    }

    /**
     * Method tests Request class
     */
    public function testRequestCheckboxSet(): void
    {
        // setup
        $router = new Router();
        Request::registerRouter($router);
        $_GET['set-field'] = 'on';

        // test body and assertions
        $this->assertTrue(Request::getChecked('set-field', [
            true,
            false
        ]));
    }

    /**
     * Method tests Request class
     */
    public function testRequestCheckboxNotSet(): void
    {
        // setup
        $router = new Router();
        Request::registerRouter($router);
        unset($_GET['set-field']);

        // test body and assertions
        $this->assertFalse(Request::getChecked('set-field', [
            true,
            false
        ]));
    }
}
