<?php

namespace Framework\Http\Pipeline;

use Framework\Http\MiddlewareResolver;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LazyMiddlewareDecorator implements MiddlewareInterface
{
    private MiddlewareResolver $resolver;
    private ContainerInterface $container;
    private string $service;

    public function __construct(MiddlewareResolver $resolver, ContainerInterface $container, string $service)
    {
        $this->resolver = $resolver;
        $this->container = $container;
        $this->service = $service;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $middleware = $this->resolver->resolve($this->container->get($this->service));
        return $middleware->process($request, $handler);
    }
}