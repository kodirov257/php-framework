<?php

namespace Tests\Framework\Http;

use Framework\Container\ServiceNotFoundException;
use Psr\Container\ContainerInterface;

class DummyContainer implements ContainerInterface
{
    public function get(string $id)
    {
        if (!class_exists($id)) {
            throw new ServiceNotFoundException($id);
        }
        return new $id();
    }

    public function has(string $id): bool
    {
        return class_exists($id);
    }
}