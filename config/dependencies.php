<?php

use App\Http\Middlewares;
use Framework\Container\Container;
use Framework\Http\ActionResolver;
use Framework\Http\Application;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response;

return [
    Middlewares\BasicAuthMiddleware::class => function (Container $container) {
        return new Middlewares\BasicAuthMiddleware($container->get('config')['users']);
    },

    Middlewares\ErrorHandlerMiddleware::class => function (Container $container) {
        return new Middlewares\ErrorHandlerMiddleware($container->get('config')['debug']);
    },

    Router::class => function (Container $container) {
        return new Router();
    },

    Application::class => function (Container $container) {
        $notFoundHandler = config('app.not_found_handler') ?? Framework\Http\Middleware\NotFoundHandler::class;
        return new Application($container->get(MiddlewareResolver::class), new $notFoundHandler());
    },

    MiddlewareResolver::class => function (Container $container) {
        return new MiddlewareResolver(new Response(), $container);
    },

    ActionResolver::class => function (Container $container) {
        return new ActionResolver($container);
    },

    Middlewares\CredentialsMiddleware::class => function () {
        return new Middlewares\CredentialsMiddleware();
    },

    Middlewares\ProfilerMiddleware::class => function () {
        return new Middlewares\ProfilerMiddleware();
    }
];
