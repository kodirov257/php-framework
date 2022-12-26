<?php

namespace Framework\Http;

use Framework\Container\Container;
use Framework\Http\Router\RouterHandler;

class ActionResolver
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param RouterHandler $handler
     * @return callable|\Closure|Controller|object
     */
    public function resolve(RouterHandler $handler): mixed
    {
        if ($handler->getAction()) {
            return $handler->getAction();
        }

        $controller = $handler->getController();
        if (\is_string($controller) && $this->container->has($controller)) {
            return $this->container->get($controller);
        }

        return !is_object($controller) ? new $controller() : $controller;
    }
}