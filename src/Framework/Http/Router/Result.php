<?php

namespace Framework\Http\Router;

use Framework\Http\Router\Exception\InsufficientMatchParametersException;

class Result
{
    private string $name;
    private RouterHandler $handler;
    private array $attributes;

    public function __construct($name, $handler, array $attributes)
    {
        $this->name = $name;
        $this->mapHandlerToObject($handler);
        $this->attributes = $attributes;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHandler(): RouterHandler
    {
        return $this->handler;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    private function mapHandlerToObject(mixed $handler): void
    {
        if (!is_array($handler)) {
            $this->handler = $handler;
        } else {
            if (!(isset($handler['controller']) && isset($handler['method'])) && !isset($handler['action'])) {
                throw new InsufficientMatchParametersException($handler);
            }

            $this->handler = new RouterHandler(
                $handler['middleware'] ?? null,
                $handler['controller'] ?? null,
                $handler['method'] ?? null,
                $handler['action'] ?? null
            );
        }
    }
}