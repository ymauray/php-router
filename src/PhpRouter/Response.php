<?php

namespace PhpRouter;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response {

    private $delegate;

    public function __construct(ResponseInterface $delegate) {
        $this->delegate = $delegate;
    }

    /**
     * @return ResponseInterface
     */
    public function getDelegate() {
        return $this->delegate;
    }

    public function produceJson($value) {
        $body = $this->getDelegate()->getBody();
        $body->write(json_encode($value));
        return $this->getDelegate()->withHeader('Content-type', 'application/json');
    }
}