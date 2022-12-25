<?php

use App\Http\Middlewares;
use Framework\Container\Container;

/* @var $container Framework\Container\Container */
$container->set(Middlewares\BasicAuthMiddleware::class, function (Container $container) {
    return new Middlewares\BasicAuthMiddleware($container->get('config')['users']);
});

$container->set(Middlewares\ErrorHandlerMiddleware::class, function (Container $container) {
    return new Middlewares\ErrorHandlerMiddleware($container->get('config')['debug']);
});