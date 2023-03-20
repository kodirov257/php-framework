<?php

use App\Console\Command;
use App\Http\Middlewares;
use DI as DependencyInjection;

return [
    Middlewares\BasicAuthMiddleware::class => DependencyInjection\factory(Infrastructure\App\Http\Middleware\BasicAuthMiddlewareFactory::class),
    Command\CacheClearCommand::class => DependencyInjection\factory(Infrastructure\App\Console\Command\CacheClearCommandFactory::class),
    PDO::class => DependencyInjection\factory(Infrastructure\App\PDOFactory::class),
];
