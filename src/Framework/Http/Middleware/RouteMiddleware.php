<?php

namespace Framework\Http\Middleware;

use Framework\Http\RequestContext;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Result;
use Framework\Http\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteMiddleware implements MiddlewareInterface
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $context = RequestContext::instance($request);
            $this->router->setContext($context);

            $result = $this->router->match($request->getUri()->getPath());
            foreach ($result->getAttributes() as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }
            return $handler->handle($request->withAttribute(Result::class, $result));
        } catch (RequestNotMatchedException $e) {
            return $handler->handle($request);
        }
    }
}
