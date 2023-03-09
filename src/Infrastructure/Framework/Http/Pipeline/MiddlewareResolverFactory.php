<?php

namespace Infrastructure\Framework\Http\Pipeline;

use Framework\Http\MiddlewareResolver;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;

class MiddlewareResolverFactory
{
    public function __invoke(ContainerInterface $container): MiddlewareResolver
    {
        return new MiddlewareResolver($container, new Response());
    }
}