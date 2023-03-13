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

    public function choose(string $prompt, array $options): string
    {
        do {
            fwrite(\STDOUT, $prompt . ' [' . implode(',', $options) . ']: ');
            $choose = trim(fgets(\STDIN));
        } while (!\in_array($choose, $options, true));
        return $choose;
    }
}