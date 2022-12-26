<?php

/* @var $container Framework\Container\Container */
/* @var $app Framework\Http\Application */
$app->pipe(\App\Http\Middlewares\ErrorHandlerMiddleware::class);
$app->pipe(\App\Http\Middlewares\CredentialsMiddleware::class);
$app->pipe(\App\Http\Middlewares\ProfilerMiddleware::class);
$app->pipe(Framework\Http\Middleware\RouteMiddleware::class);
$app->pipe(Framework\Http\Middleware\DispatchMiddleware::class);
$app->pipe(Framework\Http\Middleware\DispatchRouteMiddleware::class);
