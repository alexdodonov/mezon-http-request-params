<?php
use PHPUnit\Framework\TestCase;
use Mezon\Transport\Request;
use Mezon\Router\Router;

/**
 *
 * @author Dodonov A.A.
 */
class RequestUnitTest extends TestCase
{

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
