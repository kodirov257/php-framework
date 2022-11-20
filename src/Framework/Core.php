<?php

namespace Framework;

use Framework\Http\ActionResolver;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\RequestContext;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Core implements HttpKernelInterface
{
    public function handle(ServerRequestInterface $request, bool $catch = true): ResponseInterface
    {
        $router = new Router();

        require 'config/routes.php';

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
}