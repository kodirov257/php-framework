<?php

use App\Http\Middlewares;
use DI as DependencyInjection;
use Framework\Http\ActionResolver;
use Framework\Http\Application;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;

return [
    Middlewares\BasicAuthMiddleware::class => DependencyInjection\factory(function (ContainerInterface $container) {
        return new Middlewares\BasicAuthMiddleware($container->get('config')['users']);
    }),

    Middlewares\ErrorHandlerMiddleware::class => DependencyInjection\factory(function (ContainerInterface $container) {
        return new Middlewares\ErrorHandlerMiddleware($container->get('config')['debug']);
    }),

    Router::class => DependencyInjection\factory(function (ContainerInterface $container) {
        return new Router();
    }),

    Application::class => DependencyInjection\factory(function (ContainerInterface $container) {
        $notFoundHandler = config('app.not_found_handler') ?? Framework\Http\Middleware\NotFoundHandler::class;
        return new Application($container->get(MiddlewareResolver::class), new $notFoundHandler());
    }),

    MiddlewareResolver::class => DependencyInjection\factory(function (ContainerInterface $container) {
        return new MiddlewareResolver(new Response(), $container);
    }),

    ActionResolver::class => DependencyInjection\factory(function (ContainerInterface $container) {
        return new ActionResolver($container);
    }),
];
