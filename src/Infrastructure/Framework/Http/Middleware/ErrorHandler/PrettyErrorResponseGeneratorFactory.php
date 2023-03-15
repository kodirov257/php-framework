<?php

namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Framework\Contracts\Template\TemplateRenderer;
use Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;
use Whoops\RunInterface;

class PrettyErrorResponseGeneratorFactory
{
    public function __invoke(ContainerInterface $container): PrettyErrorResponseGenerator|WhoopsErrorResponseGenerator
    {
        if (config('parameters.debug')) {
            return new WhoopsErrorResponseGenerator(
                $container->get(RunInterface::class),
                new Response()
            );
        }
        return new PrettyErrorResponseGenerator(
            $container->get(TemplateRenderer::class),
            new Response(),
            [
                '403' => 'error/403',
                '404' => 'error/404',
                'error' => 'error/error',
            ]
        );
    }
}
