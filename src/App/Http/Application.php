<?php

namespace App\Http;

use Framework\Http\MiddlewareResolver;
use Framework\Http\Pipeline\Pipeline;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application extends Pipeline
{
    private MiddlewareResolver $resolver;
    private $default;

    public function __construct(MiddlewareResolver $resolver, callable $default)
    {
        parent::__construct();
        $this->resolver = $resolver;
        $this->default = $default;
    }

    public function pipe($middleware):void
    {
        parent::pipe($this->resolver->resolve($middleware));
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        return $this($request, $this->default);
    }
}