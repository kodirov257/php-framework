<?php

use App\Http\Middlewares;
use DI as DependencyInjection;
use Framework\Contracts\Application as ApplicationInterface;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Laminas\Diactoros\Response;
use Psr\Log\LoggerInterface;

return [
    Middlewares\BasicAuthMiddleware::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        return new Middlewares\BasicAuthMiddleware($container->get('config')['users'], new Response());
    }),

    ErrorHandlerMiddleware::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        return new ErrorHandlerMiddleware(
            $container->get(ErrorResponseGenerator::class),
            $container->get(LoggerInterface::class)
        );
    }),
];
