<?php

namespace PhpRouter\Router;


class RouterConfig
{
    private $basePath;
    private $mappings;
    private $controller;

    /**
     * RouterConfig constructor.
     */
    public function __construct($controller) {
        $this->setMappings([]);
        $this->controller = $controller;
    }

    public function addMapping($path, $mapping) {
        $this->mappings[$path] = $mapping;
    }

    public function hasMapping($path, $method) {
        if (!array_key_exists($path, $this->mappings)) { return false; }
        if ($this->mappings[$path]->getMethod() != $method) { return false; }
        return true;
    }

    /**
     * @return mixed
     */
    public function getBasePath() {
        return $this->basePath;
    }

    /**
     * @param mixed $basePath
     */
    public function setBasePath($basePath) {
        $this->basePath = $basePath;
    }

    /**
     * @return mixed
     */
    public function getMappings() {
        return $this->mappings;
    }

    /**
     * @param mixed $mappings
     */
    public function setMappings($mappings) {
        $this->mappings = $mappings;
    }

    /**
     * @return mixed
     */
    public function getController() {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller) {
        $this->controller = $controller;
    }


}