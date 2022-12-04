<?php

namespace Framework\Http\Middleware;

use Framework\Http\ActionResolver;
use Framework\Http\Controller;
use Framework\Http\Router\Result;
use Psr\Http\Message\ServerRequestInterface;

class DispatchRouteMiddleware
{
    private ActionResolver $resolver;

    public function __construct(ActionResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        /* @var Result $result */
        if (!$result = $request->getAttribute(Result::class)) {
            return $next($request);
        }

        $controller = $this->resolver->resolve($result->getHandler());
        $method = $result->getHandler()->getMethod();

        $middleware = function (ServerRequestInterface $request) use ($controller, $method) {
            return $this->runAction($controller, $method, $request);
        };

        return $middleware($request, $next);
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