<?php

namespace Framework;

use Framework;
use Framework\Bootstrap\Config\ConfigurationLoader;
use Framework\Contracts\Kernel\HttpKernelInterface;
use Framework\Http\ActionResolver;
use Framework\Http\Application;
use Framework\Http\Controller;
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

        $router = new Router();

        $params = [
            'debug' => true,
            'users' => ['admin' => 'password'],
        ];

        if (config('app.route') === Router::ATTRIBUTE_TYPE) {
            $router->registerRoutesFromAttributes($this->getControllers());
        } else {
            require 'config/routes.php';
        }

        $actionResolver = new ActionResolver();
        $middlewareResolver = new MiddlewareResolver(new Response());
        $notFoundHandler = config('app.not_found_handler') ?? Framework\Http\Middleware\NotFoundHandler::class;
        $app = new Application($middlewareResolver, new $notFoundHandler($request));

        foreach (config('app.middlewares') as $middleware) {
            $app->pipe($middleware);
        }
        $app->pipe(new Framework\Http\Middleware\RouteMiddleware($router));
        $app->pipe(new Framework\Http\Middleware\DispatchMiddleware($middlewareResolver));
        $app->pipe(new Framework\Http\Middleware\DispatchRouteMiddleware($actionResolver));

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