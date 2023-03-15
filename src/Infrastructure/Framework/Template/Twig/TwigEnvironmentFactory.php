<?php

namespace Infrastructure\Framework\Template\Twig;

use Framework\Template\Twig\Extension\RouteExtension;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class TwigEnvironmentFactory
{
    public function __invoke(ContainerInterface $container): Environment
    {
        $template = config('templates.template');
        $config = config('templates.' . $template);
        $debug = config('parameters.debug');

        $loader = new FilesystemLoader();
        $loader->addPath($config['template_dir']);

        $environment = new Environment($loader, [
            'cache' => $debug ? false : $config['cache_dir'],
            'debug' => $debug,
            'strict_variables' => $debug,
            'auto_reload' => $debug,
        ]);

        $issetFunction = new TwigFunction('isset', function ($value) {
            return isset($value);
        });
        $emptyFunction = new TwigFunction('empty', function ($value) {
            return empty($value);
        });
        $routeFunction = new TwigFunction('route', function (string $name, array $params = []) {
            return route($name, $params);
        });
        $environment->addFunction($issetFunction);
        $environment->addFunction($emptyFunction);
        $environment->addFunction($routeFunction);

        if ($debug) {
            $environment->addExtension(new DebugExtension());
        }

        $environment->addExtension($container->get(RouteExtension::class));

        foreach ($config['extensions'] as $extension) {
            $environment->addExtension($container->get($extension));
        }

        return $environment;
    }
}
