<?php

namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;
use Whoops\RunInterface;

class WhoopsErrorResponseGeneratorFactory
{
    public function __invoke(ContainerInterface $container): WhoopsErrorResponseGenerator
    {
        return new WhoopsErrorResponseGenerator(
            $container->get(RunInterface::class),
            new Response()
        );
    }
}