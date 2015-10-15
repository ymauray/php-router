<?php

namespace PhpRouter\Router;

class RequestMapping
{

    private $controllerMethod;
    private $method;
    private $path;

    /**
     * RequestMapping constructor.
     * @param $controllerMethod
     */
    public function __construct($controllerMethod) {
        $this->controllerMethod = $controllerMethod;
    }

    /**
     * @return mixed
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path) {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getControllerMethod() {
        return $this->controllerMethod;
    }

    /**
     * @param mixed $controllerMethod
     */
    public function setControllerMethod($controllerMethod) {
        $this->controllerMethod = $controllerMethod;
    }

}