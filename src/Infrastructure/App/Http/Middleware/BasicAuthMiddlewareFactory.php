<?php

namespace Infrastructure\App\Http\Middleware;

use App\Http\Middlewares\BasicAuthMiddleware;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;

class BasicAuthMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): BasicAuthMiddleware
    {
        return new BasicAuthMiddleware($container->get('config')['users'], new Response());
    }
}