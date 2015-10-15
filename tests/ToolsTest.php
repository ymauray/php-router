<?php

use PhpRouter\Tools;

class ToolsTest extends PHPUnit_Framework_TestCase
{

    public function testCamelCaseToHyphenate() {
        $this->assertEquals('my-awesome-class', Tools::camelCaseToHyphanate("MyAwesomeClass"));
        $this->assertEquals('no-change', Tools::camelCaseToHyphanate("no-change"));
        $this->assertNull(Tools::camelCaseToHyphanate(null));
        $this->assertEquals('', Tools::camelCaseToHyphanate(''));
    }

}
