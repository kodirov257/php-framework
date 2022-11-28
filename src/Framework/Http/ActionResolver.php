<?php

namespace Framework\Http;

use Framework\Http\Router\RouterHandler;

class ActionResolver
{
    public function resolve(RouterHandler $handler)
    {
        if ($handler->getAction()) {
            return $handler->getAction();
        }

        return !is_object($handler->getController()) ? new ($handler->getController())() : $handler->getController();
    }
}