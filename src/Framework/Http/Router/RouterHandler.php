<?php

namespace Framework\Http\Router;

class RouterHandler
{
    /**
     * Define controller
     *
     * @var string|object|null
     */
    private string|object|null $controller;

    /**
     * Define action method
     *
     * @var string|null
     */
    private string|null $method;

    /**
     * Define middleware
     *
     * @var mixed
     */
    private mixed $middlewares;

    /**
     * Define action if controller method is given as function
     *
     * @var callable|null
     */
    private $action;

    public function __construct(mixed $middlewares = [], string|null $controller = null, mixed $method = null, callable|null $action = null)
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->middlewares = $middlewares;
        $this->action = $action;
    }

    public function setController(object|string $controller): void
    {
        $this->controller = $controller;
    }

    public function getController(): object|string|null
    {
        return $this->controller;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getMethod(): string|null
    {
        return $this->method;
    }

    public function setMiddlewares(mixed $middlewares): void
    {
        $this->middlewares = $middlewares;
    }

    public function getMiddlewares(): mixed
    {
        return $this->middlewares;
    }

    public function setAction(callable $action): void
    {
        $this->action = $action;
    }

    public function getAction(): callable|null
    {
        return $this->action;
    }
}
