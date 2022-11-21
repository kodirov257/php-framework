<?php

namespace Framework;

use Framework\Bootstrap\Config\ConfigurationLoader;
use Framework\Contracts\Kernel\HttpKernelInterface;
use Framework\Http\ActionResolver;
use Framework\Http\RequestContext;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Finder\Finder;

class Core implements HttpKernelInterface
{
    private string $controllersNamespace = 'App\Http\Controllers';

    public function handle(ServerRequestInterface $request, bool $catch = true): ResponseInterface
    {
        $router = new Router();
        $configLoader = new ConfigurationLoader();
        $configLoader->bootstrap(new Application(dirname(__DIR__, 2)));

        if (config('app.route') === Router::ATTRIBUTE_TYPE) {
            $router->registerRoutesFromAttributes($this->getControllers());
        } else {
            require 'config/routes.php';
        }

        $resolver = new ActionResolver();

        $responseMethod = function (Router $router, ServerRequestInterface $request, ActionResolver $resolver): ResponseInterface {
            $context = RequestContext::instance($request);
            $router->setContext($context);

            $result = $router->match($request->getUri()->getPath());

            foreach ($result->getAttributes() as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }

            return $resolver->resolve($result->getHandler(), $request);
        };

        $tryCatchBlock = function (callable $callback) use ($router, $request, $resolver): ResponseInterface {
            try {
                return $callback($router, $request, $resolver);
            } catch (RequestNotMatchedException $e) {
                return new HtmlResponse('Undefined page', 404);
            }
        };

        $response = $catch ? $tryCatchBlock($responseMethod) : $responseMethod($router, $request, $resolver);

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
}