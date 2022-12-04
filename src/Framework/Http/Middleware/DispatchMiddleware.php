<?php

namespace Framework\Http\Middleware;

use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\Result;
use Psr\Http\Message\ServerRequestInterface;

class DispatchMiddleware
{
    private MiddlewareResolver $resolver;

    public function __construct(MiddlewareResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        /* @var Result $result */
        if (!$result = $request->getAttribute(Result::class)) {
            return $next($request);
        }

        $middleware = $this->resolver->resolve($result->getHandler()->getMiddlewares());
        return $middleware($request, $next);
    }
}