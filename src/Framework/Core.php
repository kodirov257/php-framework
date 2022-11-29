<?php

namespace Framework;

use App\Http\Middlewares;
use Framework\Bootstrap\Config\ConfigurationLoader;
use Framework\Contracts\Kernel\HttpKernelInterface;
use Framework\Http\ActionResolver;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Pipeline\Pipeline;
use Framework\Http\RequestContext;
use Framework\Http\Router\Exception\RequestNotMatchedException;
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

        if (config('app.route') === Router::ATTRIBUTE_TYPE) {
            $router->registerRoutesFromAttributes($this->getControllers());
        } else {
            require 'config/routes.php';
        }

        $actionResolver = new ActionResolver();
        $middlewareResolver = new MiddlewareResolver();
        $pipeline = new Pipeline();

        $pipeline->pipe($middlewareResolver->resolve(Middlewares\ProfilerMiddleware::class));

        $responseMethod = function (Router $router, ServerRequestInterface $request) use ($actionResolver, $middlewareResolver, $pipeline): ResponseInterface {
            $context = RequestContext::instance($request);
            $router->setContext($context);

            $result = $router->match($request->getUri()->getPath());

            foreach ($result->getAttributes() as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }

            $handler = $result->getHandler();
            $pipeline->pipe($middlewareResolver->resolve($handler->getMiddlewares()));

            $controller = $actionResolver->resolve($handler);
            $method = $handler->getMethod();

            $pipeline->pipe(function ($request) use ($controller, $method) {
                if ($controller instanceof \Closure) {
                    return $controller($request);
                }

                if (method_exists($controller, 'callAction')) {
                    return $controller->callAction($method, $request);
                }

                return $controller->{$method}($request);
            });

            return $pipeline($request, new Middlewares\NotFoundHandler());
        };

        $tryCatchBlock = function (callable $callback) use ($router, $request): ResponseInterface {
            try {
                return $callback($router, $request);
            } catch (RequestNotMatchedException $e) {
                $handler = new Middlewares\NotFoundHandler();
                return $handler($request);
            }
        };

        $response = $catch ? $tryCatchBlock($responseMethod) : $responseMethod($router, $request);

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