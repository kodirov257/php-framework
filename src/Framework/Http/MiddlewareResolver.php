<?php

namespace Framework\Http;

use Framework\Http\Router\RouterHandler;
use Psr\Http\Message\ServerRequestInterface;

class MiddlewareResolver
{
    public function resolve(mixed $handler): callable
    {
        return is_string($handler) ? new $handler : $handler;
    }
}