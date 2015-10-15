<?php

namespace PhpRouter;

use Psr\Http\Message\ServerRequestInterface;

class Request
{
    private $delegate;

    public function __construct(ServerRequestInterface $delegate) {
        $this->delegate = $delegate;
    }

}