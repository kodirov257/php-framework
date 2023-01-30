<?php

use DI as DependencyInjection;
use Framework\Contracts\Application as ApplicationInterface;
use Framework\Http\ActionResolver;
use Framework\Http\HttpApplication;
use Framework\Http\MiddlewareResolver;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response;

return [
    HttpApplication::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        $notFoundHandler = config('app.not_found_handler') ?? Framework\Http\Middleware\NotFoundHandler::class;
        return new HttpApplication($container->get(MiddlewareResolver::class), new $notFoundHandler());
    }),

    MiddlewareResolver::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        return new MiddlewareResolver(new Response(), $container);
    }),

    ActionResolver::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        return new ActionResolver($container);
    }),

    TemplateRenderer::class => DependencyInjection\factory(function () {
        return new TemplateRenderer('templates');
    }),
];
