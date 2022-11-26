<?php

namespace Framework\Http;

use Psr\Http\Message\ServerRequestInterface;

class ActionResolver
{
    public function resolve($handler, ServerRequestInterface $request)
    {
        $controller = \is_array($handler)
            ? (!is_object($handler['controller']) ? new $handler['controller']() : $handler['controller'])
            : $handler;

        return $controller->{$handler['method']}($request);
    }
}