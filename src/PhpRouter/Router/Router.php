<?php

namespace PhpRouter\Router;

use ReflectionClass;
use ReflectionMethod;
use Slim\App;
use PhpRouter\DocParser;
use PhpRouter\Tools;
use PhpRouter\Response;
use PhpRouter\Request;

class Router {

    private $configs;

    public function __construct() {
        $this->configs = [];
    }

    public function controller($controller) {
        $config = new RouterConfig($controller);
        $ref = new ReflectionClass($controller);
        $parser = new DocParser($ref->getDocComment());
        $config->setBasePath($parser->hasTag('Path') ? $parser->getTag('Path') : $this->deriveBasePath($ref));

        $methods = $ref->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach($methods as $method) {
            $name = $method->getName();
            $parser = new DocParser($method->getDocComment());
            $mapping = new RequestMapping($name);
            if (!$parser->hasTag('Path') && !$parser->hasTag('Method')) {
                $a = Tools::splitCamelCase($name);
                if (($a[0] == 'get') || ($a[0] == 'post')) {
                    $mapping->setMethod(strtoupper($a[0]));
                    array_shift($a);
                } else {
                    $mapping->setMethod('GET');
                }
                $mapping->setPath('/' . strtolower(join('-', $a)));
            } else {
                if ($parser->hasTag('Method')) {
                    $mapping->setMethod(strtoupper($parser->getTag('Method')));
                } else {
                    $mapping->setMethod('GET');
                }
                if ($parser->hasTag('Path')) {
                    $mapping->setPath($parser->getTag('Path'));
                } else {
                    $mapping->setPath('/' . Tools::camelCaseToHyphanate($name));
                }
            }
            $config->addMapping($mapping->getPath(), $mapping);
        }

        $this->configs[] = $config;

        return $config;
    }

    public function deriveBasePath(ReflectionClass $ref) {
        $name = $ref->getName();
        return '/' . Tools::camelCaseToHyphanate($name);
    }

    public function apply(App $app) {
        foreach($this->configs as $config) {
            $basePath = $config->getBasePath();
            foreach($config->getMappings() as $mapping) {
                $path = $mapping->getPath();
                if ($path == '/') { $path = ''; }
                $path = $basePath . $path;
                $app->{strtolower($mapping->getMethod())}($path, function($request, $response, $args) use($config, $mapping) {
                    $req = new Request($request);
                    $resp = new Response($response);
                    $value = $config->getController()->{$mapping->getControllerMethod()}($req, $resp, $args);
                    return $value;
                });
            }
        }
    }
}