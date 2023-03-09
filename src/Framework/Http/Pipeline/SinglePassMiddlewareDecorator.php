<?php

namespace Framework\Http\Pipeline;

use Laminas\Stratigility\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class SinglePassMiddlewareDecorator implements MiddlewareInterface
{
    private $middleware;

    public function __construct(callable $middleware)
    {
        $this->middleware = $middleware;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = ($this->middleware)(
            $request,
            $this->decorateHandler($handler)
        );

        if (!$response instanceof ResponseInterface) {
            throw Exception\MissingResponseException::forCallableMiddleware($this->middleware);
        }

        return $response;
    }

    private function decorateHandler(RequestHandlerInterface $handler): callable
    {
        return function ($request) use ($handler) {
            return $handler->handle($request);
        };
    }
}
