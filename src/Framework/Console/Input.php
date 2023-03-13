<?php

namespace Framework\Console;

class Input
{
    private array $args;

    public function __construct(array $args)
    {
        $this->args = \array_slice($args, 1);
    }

    public function getArgument(int $index): string
    {
        return $this->args[$index] ?? '';
    }
}