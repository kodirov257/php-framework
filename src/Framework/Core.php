<?php

namespace Framework;

use Framework;
use Framework\Bootstrap\Config\ConfigurationLoader;
use Framework\Container\Container;
use Framework\Contracts\Kernel\HttpKernelInterface;
use Framework\Http\ActionResolver;
use Framework\Http\Application;
use Framework\Http\Middleware\DispatchMiddleware;
use Framework\Http\Middleware\DispatchRouteMiddleware;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Finder\Finder;
use Dotenv\Dotenv;

class Core implements HttpKernelInterface
{
    private string $controllersNamespace = 'App\Http\Controllers';

    public function handle(ServerRequestInterface $request, bool $catch = true): ResponseInterface
    {
        $this->setConfiguration();

        $container = new Container();
        $container->set('config', [
            'debug' => true,
            'users' => ['admin' => 'password'],
        ]);
        require 'config/container.php';

        $container->set(Router::class, function (Container $container) {
            $router = new Router();

            if (config('app.route') === Router::ATTRIBUTE_TYPE) {
                $router->registerRoutesFromAttributes($this->getControllers());
            } else {
                require 'config/routes.php';
            }

            return $router;
        });

        $container->set(Application::class, function (Container $container) use ($request) {
            $notFoundHandler = config('app.not_found_handler') ?? Framework\Http\Middleware\NotFoundHandler::class;
            return new Application($container->get(MiddlewareResolver::class), new $notFoundHandler($request));
        });

        $container->set(RouteMiddleware::class, function (Container $container) {
            return new RouteMiddleware($container->get(Router::class));
        });

        $container->set(DispatchMiddleware::class, function (Container $container) {
            return new DispatchMiddleware($container->get(MiddlewareResolver::class));
        });

        $container->set(DispatchRouteMiddleware::class, function (Container $container) {
            return new DispatchRouteMiddleware($container->get(ActionResolver::class));
        });

        $container->set(MiddlewareResolver::class, function (Container $container) {
            return new MiddlewareResolver(new Response(), $container);
        });

        $container->set(ActionResolver::class, function (Container $container) {
            return new ActionResolver();
        });



        ### Initialization
        /** @var $app Application */
        $app = $container->get(Application::class);

        require 'config/pipeline.php';
        $app->pipe($container->get(Framework\Http\Middleware\RouteMiddleware::class));
        $app->pipe($container->get(Framework\Http\Middleware\DispatchMiddleware::class));
        $app->pipe($container->get(Framework\Http\Middleware\DispatchRouteMiddleware::class));

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

    private function setConfiguration(): void
    {
        $basePath = dirname(__DIR__, 2);
        $dotenv = Dotenv::createImmutable($basePath);
        $dotenv->load();

        $configLoader = new ConfigurationLoader();
        $configLoader->bootstrap(new ApplicationInfo($basePath));
    }
}