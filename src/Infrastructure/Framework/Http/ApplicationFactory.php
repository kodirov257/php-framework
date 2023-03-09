<?php

namespace Infrastructure\Framework\Http;

use Framework\Http\HttpApplication;
use Framework\Http\MiddlewareResolver;
use Psr\Container\ContainerInterface;
use Framework;

class ApplicationFactory
{
    public function __invoke(ContainerInterface $container): HttpApplication
    {
        $notFoundHandler = config('app.not_found_handler') ?? Framework\Http\Middleware\NotFoundHandler::class;
        return new HttpApplication(
            $container->get(MiddlewareResolver::class),
            $container->get($notFoundHandler)
        );
    }
}
