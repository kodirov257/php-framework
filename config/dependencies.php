<?php

use App\Http\Middlewares;
use DI as DependencyInjection;
use Framework\Contracts\Application as ApplicationInterface;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\LogErrorListener;
use Laminas\Diactoros\Response;

return [
    Middlewares\BasicAuthMiddleware::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        return new Middlewares\BasicAuthMiddleware($container->get('config')['users'], new Response());
    }),

    ErrorHandlerMiddleware::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        $middleware = new ErrorHandlerMiddleware($container->get(ErrorResponseGenerator::class));
        $middleware->addListener($container->get(LogErrorListener::class));
        return $middleware;
    }),
];
