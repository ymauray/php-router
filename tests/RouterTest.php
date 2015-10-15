<?php

use PhpRouter\Router\Router;
use PhpRouter\Router\RouterConfig;

/**
 * Class MyRouterTestController
 */
class MyRouterTestController {

    /**
     * Derive path and method.
     */
    public function getDemo() {}

    /**
     * Derive path and method.
     */
    public function postNewUser() {}

    /**
     * Derive path and use default GET method.
     */
    public function createUser() {}

    /**
     * Use provided path, and default GET method.
     * @Path /somewhere
     */
    public function postSomething() {}

    /**
     * Use provided method and derive path (full).
     * @Method POST
     */
    public function getSomething() {}

    /**
     * This should not be considered.
     */
    private function somePrivateMethod() {}
}

/**
 * Class MyAnnotatedController
 *
 * @Path /anno
 */
class MyAnnotatedController {

}

class RouterTest extends PHPUnit_Framework_TestCase
{

    public function testDeriveBasePath() {
        $router = new Router();
        $config = $router->controller(new MyRouterTestController());
        $this->assertEquals('/my-router-test-controller', $config->getBasePath());
    }

    public function testExplicitBasePath() {
        $router = new Router();
        $config = $router->controller(new MyAnnotatedController());
        $this->assertEquals('/anno', $config->getBasePath());
    }

    public function testMethodPaths() {
        $router = new Router();
        $config = $router->controller(new MyRouterTestController());
        $this->assertNotNull($config->getMappings());
        $this->assertEquals(5, sizeof($config->getMappings()));
        $this->assertTrue($config->hasMapping('/demo', 'GET'));
        $this->assertTrue($config->hasMapping('/new-user', 'POST'));
        $this->assertTrue($config->hasMapping('/create-user', 'GET'));
        $this->assertTrue($config->hasMapping('/somewhere', 'GET'));
        $this->assertTrue($config->hasMapping('/get-something', 'POST'));
    }
}
