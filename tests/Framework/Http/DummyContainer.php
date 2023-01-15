<?php

namespace Tests\Framework\Http;

use DI\NotFoundException;
use Psr\Container\ContainerInterface;

class DummyContainer implements ContainerInterface
{
    public function get(string $id)
    {
        if (!class_exists($id)) {
            throw new NotFoundException($id);
        }
        return new $id();
    }

    public function has(string $id): bool
    {
        return class_exists($id);
    }
}