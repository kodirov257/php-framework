<?php

namespace Framework;

use App\Http\Middlewares;
use Framework;
use Framework\Bootstrap\Config\ConfigurationLoader;
use Framework\Contracts\Kernel\HttpKernelInterface;
use Framework\Http\ActionResolver;
use Framework\Http\Application;
use Framework\Http\Controller;
use Framework\Http\MiddlewareResolver;
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
        $middlewareResolver = new MiddlewareResolver();
        $app = new Application($middlewareResolver, new Middlewares\NotFoundHandler());

        $app->pipe(new Middlewares\ErrorHandlerMiddleware($params['debug']));
        $app->pipe(Middlewares\CredentialsMiddleware::class);
        $app->pipe(Middlewares\ProfilerMiddleware::class);
        $app->pipe(new Framework\Http\Middleware\RouteMiddleware($router));
        $app->pipe(new Framework\Http\Middleware\DispatchMiddleware($middlewareResolver));
        $app->pipe(new Framework\Http\Middleware\DispatchRouteMiddleware($actionResolver));

        $response = $app->run($request);

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

    /**
     * Run action in controller.
     *
     * @param callable|\Closure|Controller|object $controller
     * @param string $method
     * @param ServerRequestInterface $request
     * @return mixed
     */
    private function runAction(mixed $controller, string $method, ServerRequestInterface $request): mixed
    {
        if ($controller instanceof \Closure) {
            return $controller($request);
        }

        if (method_exists($controller, 'callAction')) {
            return $controller->callAction($method, $request);
        }

        return $controller->{$method}($request);
    }
}