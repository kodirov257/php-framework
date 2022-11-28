<?php

namespace Framework\Http;

use Framework\Http\Router\RouterHandler;

class ActionResolver
{
    public function resolve(RouterHandler $handler)
    {
        return !is_object($handler->getController()) ? new ($handler->getController())() : $handler->getController();
    }
}