<?php

use App\Http\Middlewares;
use App\Http\Middlewares\ErrorHandler\DebugErrorResponseGenerator;
use App\Http\Middlewares\ErrorHandler\ErrorHandlerMiddleware;
use App\Http\Middlewares\ErrorHandler\ErrorResponseGenerator;
use App\Http\Middlewares\ErrorHandler\PrettyErrorResponseGenerator;
use DI as DependencyInjection;
use Framework\Contracts\Application as ApplicationInterface;
use Laminas\Diactoros\Response;

return [
    Middlewares\BasicAuthMiddleware::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        return new Middlewares\BasicAuthMiddleware($container->get('config')['users'], new Response());
    }),

    ErrorHandlerMiddleware::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        return new ErrorHandlerMiddleware($container->get(ErrorResponseGenerator::class));
    }),

    ErrorResponseGenerator::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        if ($container->get('config')['debug']) {
            return new DebugErrorResponseGenerator('error/error-debug');
        }
        return new PrettyErrorResponseGenerator(
            [
                '403' => 'error/403',
                '404' => 'error/404',
                'error' => 'error/error',
            ]
        );
    }),
];
