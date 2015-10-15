<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoloader

use PhpRouter\Router;
use PhpRouter\DocParser;
use PhpRouter\Exception\UnknownTagException;

/**
 * Class MyController
 *
 * @Path /my-controller
 */
class MyController {

    /**
     * @Path /demo
     * @Method GET
     */
    public function demo() {

    }

}

class DocParserTest extends PHPUnit_Framework_TestCase {

    public function testTypeAnnotations() {
        $ref = new ReflectionClass(new MyController());
        $parser = new DocParser($ref->getDocComment());
        $this->assertTrue($parser->hasTag('Path'));
        $this->assertEquals($parser->getTag('Path'), '/my-controller');
        $this->assertFalse($parser->hasTag('Option'));
    }

    public function testMethodAnnotation() {
        $ref = new ReflectionClass(new MyController());
        $refMeth = $ref->getMethod('demo');
        $parser = new DocParser($refMeth->getDocComment());
        $this->assertTrue($parser->hasTag('Path'));
        $this->assertTrue($parser->hasTag('Method'));
        $this->assertFalse($parser->hasTag('Options'));
    }

    public function testException() {
        $ref = new ReflectionClass(new MyController());
        $parser = new DocParser($ref->getDocComment());
        $catched = false;
        try {
            $parser->getTag('Options');
        } catch (UnknownTagException $exception) {
            $catched = true;
        }
        $this->assertTrue($catched);
    }

}
