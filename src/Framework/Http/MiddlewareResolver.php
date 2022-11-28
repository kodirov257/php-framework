<?php

namespace Framework\Http;

use Psr\Http\Message\ServerRequestInterface;

class MiddlewareResolver
{
    public function resolve(mixed $handler): callable
    {
        if (\is_string($handler)) {
            return function (ServerRequestInterface $request, callable $next) use ($handler) {
                $object = new $handler();
                return $object($request, $next);
            };
        }
        return $handler;
    }
}