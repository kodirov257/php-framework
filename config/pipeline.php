<?php

/* @var $app Framework\Http\Application */
$app->pipe(\App\Http\Middlewares\ErrorHandlerMiddleware::class);
$app->pipe(\App\Http\Middlewares\CredentialsMiddleware::class);
$app->pipe(\App\Http\Middlewares\ProfilerMiddleware::class);