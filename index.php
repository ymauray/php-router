<?php

require_once('vendor/autoload.php');

use Slim\App;
use PhpRouter\Router\Router;
use Psr\Http\Message\ServerRequestInterface;
use PhpRouter\Response;

/**
 * Class ExampleController
 *
 * @Path /example
 */
class ExampleController {

    public function getStatus() {
        echo "getStatus !!\n";
    }

    /**
     * @param ServerRequestInterface $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\MessageInterface
     *
     * @Path /greetings/{msg}
     * @Method GET
     */
    public function sayHello(ServerRequestInterface $request, Response $response, $args) {
        $value = [
            'message' => $args['msg'],
            'from' => 'me',
            'to' => 'you'
        ];
        return $response->produceJson($value);
    }
}

/**
 * Class OtherController
 */
class OtherController {

    /**
     * This Path is intentionnaly empty. The root method will match /other-controller request.
     * @Path /
     * @Method GET
     */
    public function root() {

    }

}

$app = new App();
$router = new Router();

$router->controller(new ExampleController());
$router->controller(new OtherController());

$router->apply($app);

$app->run();
