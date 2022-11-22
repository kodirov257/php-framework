<?php

namespace Framework\Contracts\Config;

interface Repository
{
    public function has(string $key): bool;

    public function get(string|array $key, mixed $default = null): mixed;

    public function all(): array;

    public function set(string|array $key, mixed $value): void;

    public function prepend(string $key, mixed $value): void;

    public function push(string $key, mixed $value): void;

}