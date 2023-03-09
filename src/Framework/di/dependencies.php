<?php

use DI as DependencyInjection;
use Framework\Contracts\Template\TemplateRenderer;
use Framework\Http\ActionResolver;
use Framework\Http\HttpApplication;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Framework\Http\MiddlewareResolver;
use Infrastructure\Framework;

return [
    HttpApplication::class => DependencyInjection\factory(Framework\Http\ApplicationFactory::class),
    MiddlewareResolver::class => DependencyInjection\factory(Framework\Http\Pipeline\MiddlewareResolverFactory::class),
    ActionResolver::class => DependencyInjection\factory(Framework\Http\ActionResolverFactory::class),
    TemplateRenderer::class => DependencyInjection\factory(Framework\Template\TemplateRendererFactory::class),
    Twig\Environment::class => DependencyInjection\factory(Framework\Template\Twig\TwigEnvironmentFactory::class),
    ErrorHandlerMiddleware::class => DependencyInjection\factory(Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddlewareFactory::class),
    ErrorResponseGenerator::class => DependencyInjection\factory(Framework\Http\Middleware\ErrorHandler\PrettyErrorResponseGeneratorFactory::class),
    Whoops\RunInterface::class => DependencyInjection\factory(Framework\Http\Middleware\ErrorHandler\WhoopsRunFactory::class),
    Psr\Log\LoggerInterface::class => DependencyInjection\factory(Framework\Logger\LoggerFactory::class),
];
