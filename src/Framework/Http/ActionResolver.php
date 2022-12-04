<?php

namespace Framework\Http;

use Framework\Http\Router\RouterHandler;

class ActionResolver
{
    /**
     * @param RouterHandler $handler
     * @return callable|\Closure|Controller|object
     */
    public function resolve(RouterHandler $handler)
    {
        if ($handler->getAction()) {
            return $handler->getAction();
        }

        return !is_object($handler->getController()) ? new ($handler->getController())() : $handler->getController();
    }
}