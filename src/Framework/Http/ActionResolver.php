<?php

namespace Framework\Http;

use Psr\Http\Message\ServerRequestInterface;

class ActionResolver
{
    public function resolve($handler, ServerRequestInterface $request)
    {
        if (isset($handler['middleware']) && !empty($handler['middleware'])) {
            return $handler['middleware']($request);
        }

        $controller = \is_array($handler)
            ? (!is_object($handler['controller']) ? new $handler['controller']() : $handler['controller'])
            : $handler;

        if (method_exists($controller, 'callAction')) {
            return $controller->callAction($handler['method'], $request);
        }

        if (strpos(get_class($controller), 'Decorator')) {
            return $controller($request);
        }

        return $controller->{$handler['method']}($request);
    }
}