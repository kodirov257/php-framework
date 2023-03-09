<?php

namespace Framework\Http\Router\Exception;

class RouteNotFoundException extends \LogicException
{
    private string $name;
    private array $params;

    public function __construct(string $name, array $params, \Throwable $previous = null)
    {
        parent::__construct('Route "' . $name . '" not found.', 0, $previous);
        $this->name = $name;
        $this->params = $params;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
