<?php

namespace Framework\Http;

use Psr\Http\Message\ServerRequestInterface;

class ActionResolver
{
    public function resolve($handler, ServerRequestInterface $request)
    {
        return \is_array($handler) ? (new $handler[0]())->{$handler[1]}($request) : $handler;
    }
}