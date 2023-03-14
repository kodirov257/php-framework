<?php

namespace Framework;

use DI;
use Framework\Bootstrap\Config\ConfigurationLoader;
use Framework\Contracts\Application as ApplicationInterface;
use Framework\Contracts\Kernel\HttpKernelInterface;
use Framework\Http\HttpApplication;
use Framework\Http\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Finder\Finder;
use Dotenv\Dotenv;

class Core implements HttpKernelInterface
{
    private string $controllersNamespace = 'App\Http\Controllers';

    public function handle(ServerRequestInterface $request, bool $catch = true): ResponseInterface
    {
        /**
         * @var $app HttpApplication
         * @var $router Router
         * @var $container Application
         */
        $container = self::InitializeContainer();
        self::SetConfiguration($container);
        $app = $container->get(HttpApplication::class);
        $router = $container->get(Router::class);

        require 'config/pipeline.php';

        if (config('app.route') === Router::ATTRIBUTE_TYPE) {
            $router->registerRoutesFromAttributes($this->getControllers());
        } else {
            require 'config/routes.php';
        }

        $response = $app->handle($request);

        return $response->withHeader('X-Developer', 'Abdurakhmon Kodirov');
    }

    /**
     * @return string[]
     */
    private function getControllers(): array
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../' . str_replace('\\', DIRECTORY_SEPARATOR, $this->controllersNamespace))->name('*Controller.php');
        $controllers = [];
        foreach ($finder as $file) {
            $controllers[] = $this->controllersNamespace . '\\' . str_replace(DIRECTORY_SEPARATOR, '\\', explode('.', $file->getRelativePathname())[0]);
        }

        return $controllers;
    }

    public static function SetConfiguration(ApplicationInterface $application): void
    {
        $basePath = dirname(__DIR__, 2);
        $dotenv = Dotenv::createImmutable($basePath);
        $dotenv->load();

        $configLoader = new ConfigurationLoader();
        $configLoader->bootstrap($application->setBasePath($basePath));
    }

    public static function InitializeContainer(): ApplicationInterface
    {
        $builder = new DI\ContainerBuilder(Application::class);
        $builder->useAttributes(true);
        $builder->addDefinitions(array_merge_recursive(
            require __DIR__ . '/di/dependencies.php',
            require 'config/dependencies.php'
        ));

        /* @var $container Application */
        $container = $builder->build();
        Application::setInstance($container);

        $container->set('config', require 'config/parameters.php');

        return $container;
    }
}
