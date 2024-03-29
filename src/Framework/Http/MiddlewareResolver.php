<?php

namespace Framework\Http;

use Framework\Http\Pipeline\LazyMiddlewareDecorator;
use Framework\Http\Pipeline\SinglePassMiddlewareDecorator;
use Framework\Http\Pipeline\UnknownMiddlewareTypeException;
use Laminas\Stratigility\Middleware\CallableMiddlewareDecorator;
use Laminas\Stratigility\Middleware\DoublePassMiddlewareDecorator;
use Laminas\Stratigility\Middleware\RequestHandlerMiddleware;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareResolver
{
    private ResponseInterface $responsePrototype;
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container, ResponseInterface $responsePrototype)
    {
        $this->responsePrototype = $responsePrototype;
        $this->container = $container;
    }

    public function resolve(mixed $handler): MiddlewareInterface
    {
        if (\is_array($handler)) {
            return $this->createPipe($handler);
        }

        if (\is_string($handler) && $this->container->has($handler)) {
            return new LazyMiddlewareDecorator($this, $this->container, $handler);
        }

        if ($handler instanceof MiddlewareInterface) {
            return $handler;
        }

        if ($handler instanceof RequestHandlerInterface) {
            return new RequestHandlerMiddleware($handler);
        }

        if ($handler instanceof \Closure) {
            $reflection = new \ReflectionFunction($handler);
            return $this->resolveObject($handler, $reflection);
        }

        if (\is_object($handler)) {
            $reflection = new \ReflectionClass($handler);
            if ($reflection->hasMethod('__invoke')) {
                $method = $reflection->getMethod('__invoke');
                return $this->resolveObject($handler, $method);
            }
        }

        throw new UnknownMiddlewareTypeException($handler);
    }

    private function createPipe(array $handlers): MiddlewarePipe
    {
        $pipeline = new MiddlewarePipe();
        foreach ($handlers as $handler) {
            $pipeline->pipe($this->resolve($handler));
        }
        return $pipeline;
    }

    private function resolveObject(mixed $handler, \ReflectionFunctionAbstract $functionOrMethod): SinglePassMiddlewareDecorator|DoublePassMiddlewareDecorator
    {
        $parameters = $functionOrMethod->getParameters();
        if (\count($parameters) === 2 && $parameters[1]->getType()->getName() === 'callable') {
            return new SinglePassMiddlewareDecorator($handler);
        }
        return new DoublePassMiddlewareDecorator($handler, $this->responsePrototype);
    }
}
