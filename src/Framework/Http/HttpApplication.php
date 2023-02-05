<?php

namespace Framework\Http;

use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HttpApplication implements MiddlewareInterface, RequestHandlerInterface
{
    private MiddlewareResolver $resolver;
    private RequestHandlerInterface $default;
    private MiddlewarePipe $pipeline;

    public function __construct(MiddlewareResolver $resolver, RequestHandlerInterface $default)
    {
        $this->resolver = $resolver;
        $this->default = $default;
        $this->pipeline = new MiddlewarePipe();
    }

    public function pipe($middleware):void
    {
        $this->pipeline->pipe($this->resolver->resolve($middleware));
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        return $this->pipeline->process($request, $this->default);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->pipeline->process($request, $handler);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->pipeline->process($request, $this->default);
    }
}