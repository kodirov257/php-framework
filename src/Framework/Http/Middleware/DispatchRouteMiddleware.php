<?php

namespace Framework\Http\Middleware;

use Framework\Http\ActionResolver;
use Framework\Http\Controller;
use Framework\Http\Router\Result;
use Laminas\Stratigility\Middleware\CallableMiddlewareDecorator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DispatchRouteMiddleware implements MiddlewareInterface
{
    private ActionResolver $resolver;

    public function __construct(ActionResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /* @var Result $result */
        if (!$result = $request->getAttribute(Result::class)) {
            return $handler->handle($request);
        }

        $middleware = new CallableMiddlewareDecorator(function (ServerRequestInterface $request) use ($result) {
            $controller = $this->resolver->resolve($result->getHandler());
            $method = $result->getHandler()->getMethod();

            return $this->runAction($controller, $method, $request);
        });

        return $middleware->process($request, $handler);
    }

    /**
     * Run action in controller.
     *
     * @param callable|\Closure|Controller|object $controller
     * @param ?string $method
     * @param ServerRequestInterface $request
     * @return mixed
     */
    private function runAction(mixed $controller, ?string $method, ServerRequestInterface $request): mixed
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