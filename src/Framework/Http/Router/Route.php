<?php

namespace Framework\Http\Router;

class Route
{
    public string $name;
    public string $pattern;
    public mixed $handler;
    public array $tokens;
    public array $methods;

    public function __construct($name, $pattern, $handler, array $methods, array $tokens = [])
    {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->handler = $handler;
        $this->methods = $methods;
        $this->tokens = $tokens;
    }
}