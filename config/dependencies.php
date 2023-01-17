<?php

use App\Http\Middlewares;
use DI as DependencyInjection;
use Psr\Container\ContainerInterface;

return [
    Middlewares\BasicAuthMiddleware::class => DependencyInjection\factory(function (ContainerInterface $container) {
        return new Middlewares\BasicAuthMiddleware($container->get('config')['users']);
    }),

    Middlewares\ErrorHandlerMiddleware::class => DependencyInjection\factory(function (ContainerInterface $container) {
        return new Middlewares\ErrorHandlerMiddleware($container->get('config')['debug']);
    }),
];
