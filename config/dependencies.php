<?php

use App\Http\Middlewares;
use Framework\Container\Container;
use Framework\Http\ActionResolver;
use Framework\Http\Application;
use Framework\Http\Middleware\DispatchMiddleware;
use Framework\Http\Middleware\DispatchRouteMiddleware;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response;

/* @var $container Framework\Container\Container */
$container->set(Middlewares\BasicAuthMiddleware::class, function (Container $container) {
    return new Middlewares\BasicAuthMiddleware($container->get('config')['users']);
});

$container->set(Middlewares\ErrorHandlerMiddleware::class, function (Container $container) {
    return new Middlewares\ErrorHandlerMiddleware($container->get('config')['debug']);
});

$container->set(Router::class, function (Container $container) {
    return new Router();
});

$container->set(Application::class, function (Container $container) {
    $notFoundHandler = config('app.not_found_handler') ?? Framework\Http\Middleware\NotFoundHandler::class;
    return new Application($container->get(MiddlewareResolver::class), new $notFoundHandler());
});

$container->set(RouteMiddleware::class, function (Container $container) {
    return new RouteMiddleware($container->get(Router::class));
});

$container->set(DispatchMiddleware::class, function (Container $container) {
    return new DispatchMiddleware($container->get(MiddlewareResolver::class));
});

$container->set(DispatchRouteMiddleware::class, function (Container $container) {
    return new DispatchRouteMiddleware($container->get(ActionResolver::class));
});

$container->set(MiddlewareResolver::class, function (Container $container) {
    return new MiddlewareResolver(new Response(), $container);
});

$container->set(ActionResolver::class, function (Container $container) {
    return new ActionResolver($container);
});

$container->set(Middlewares\CredentialsMiddleware::class, function () {
    return new Middlewares\CredentialsMiddleware();
});

$container->set(Middlewares\ProfilerMiddleware::class, function () {
    return new Middlewares\ProfilerMiddleware();
});
