<?php

use DI as DependencyInjection;
use Framework\Contracts\Application as ApplicationInterface;
use Framework\Contracts\Template\TemplateRenderer;
use Framework\Http\ActionResolver;
use Framework\Http\HttpApplication;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;
use Framework\Http\MiddlewareResolver;
use Framework\Template\Twig\Extension\RouteExtension;
use Framework\Template\Twig\TwigRenderer;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\PrettyErrorResponseGenerator;
use Laminas\Diactoros\Response;

return [
    HttpApplication::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        $notFoundHandler = config('app.not_found_handler') ?? Framework\Http\Middleware\NotFoundHandler::class;
        return new HttpApplication($container->get(MiddlewareResolver::class), $container->get($notFoundHandler));
    }),

    MiddlewareResolver::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        return new MiddlewareResolver($container, new Response());
    }),

    ActionResolver::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        return new ActionResolver($container);
    }),

    TemplateRenderer::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        return new TwigRenderer($container->get(Twig\Environment::class), config('templates.extension'));
    }),

    Twig\Environment::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        $template = config('templates.template');
        $config = config('templates.' . $template);
        $debug = $container->get('config')['debug'];

        $loader = new Twig\Loader\FilesystemLoader();
        $loader->addPath($config['template_dir']);

        $environment = new Twig\Environment($loader, [
            'cache' => $debug ? false : $config['cache_dir'],
            'debug' => $debug,
            'strict_variables' => $debug,
            'auto_reload' => $debug,
        ]);

        $issetFunction = new Twig\TwigFunction('isset', function ($value) {
            return isset($value);
        });
        $emptyFunction = new Twig\TwigFunction('empty', function ($value) {
            return empty($value);
        });
        $routeFunction = new Twig\TwigFunction('route', function (string $name, array $params = []) {
            return route($name, $params);
        });
        $environment->addFunction($issetFunction);
        $environment->addFunction($emptyFunction);
        $environment->addFunction($routeFunction);

        if ($debug) {
            $environment->addExtension(new Twig\Extension\DebugExtension());
        }

        $environment->addExtension($container->get(RouteExtension::class));

        foreach ($config['extensions'] as $extension) {
            $environment->addExtension($container->get($extension));
        }

        return $environment;
    }),

    ErrorResponseGenerator::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        if ($container->get('config')['debug']) {
            return new WhoopsErrorResponseGenerator(
                $container->get(Whoops\RunInterface::class),
                new Laminas\Diactoros\Response()
            );
        }
        return new PrettyErrorResponseGenerator(
            $container->get(TemplateRenderer::class),
            new Laminas\Diactoros\Response(),
            [
                '403' => 'error/403',
                '404' => 'error/404',
                'error' => 'error/error',
            ]
        );
    }),

    Whoops\RunInterface::class => DependencyInjection\factory(function () {
        $whoops = new Whoops\Run();
        $whoops->allowQuit(false);
        $whoops->writeToOutput(false);
        $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
        $whoops->register();
        return $whoops;
    }),

    Psr\Log\LoggerInterface::class => DependencyInjection\factory(function (ApplicationInterface $container) {
        $logger = new Monolog\Logger('App');
        $logger->pushHandler(new Monolog\Handler\StreamHandler(
            'var/log/application.log',
            $container->get('config')['debug'] ? Monolog\Logger::DEBUG : Monolog\Logger::WARNING
        ));
        return $logger;
    }),
];
