<?php

namespace Framework\Http\Router;

class Result
{
    private string $name;
    private mixed $handler;
    private array $attributes;

    public function __construct($name, $handler, array $attributes)
    {
        $this->name = $name;
        $this->handler = $handler;
        $this->attributes = $attributes;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHandler(): mixed
    {
        return $this->handler;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }


}