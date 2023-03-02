<?php

/* @var $container DI\Container */
/* @var $app Framework\Http\HttpApplication */
$app->pipe(\App\Http\Middlewares\ErrorHandler\ErrorHandlerMiddleware::class);
$app->pipe(\App\Http\Middlewares\CredentialsMiddleware::class);
$app->pipe(\App\Http\Middlewares\ProfilerMiddleware::class);
$app->pipe(Framework\Http\Middleware\RouteMiddleware::class);
$app->pipe(Framework\Http\Middleware\DispatchMiddleware::class);
$app->pipe(Framework\Http\Middleware\DispatchRouteMiddleware::class);
