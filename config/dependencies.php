<?php

use App\Http\Middlewares;
use DI as DependencyInjection;
use Infrastructure\App;

return [
    Middlewares\BasicAuthMiddleware::class => DependencyInjection\factory(App\Http\Middleware\BasicAuthMiddlewareFactory::class),
];
