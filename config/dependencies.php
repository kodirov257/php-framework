<?php

use App\Http\Middlewares;
use DI as DependencyInjection;
use Framework\Contracts\Application as ApplicationInterface;
use Framework\Contracts\Template\TemplateRenderer;

return [
    Middlewares\BasicAuthMiddleware::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        return new Middlewares\BasicAuthMiddleware($container->get('config')['users']);
    }),

    Middlewares\ErrorHandlerMiddleware::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        return new Middlewares\ErrorHandlerMiddleware($container->get('config')['debug'], $container->get(TemplateRenderer::class));
    }),
];
