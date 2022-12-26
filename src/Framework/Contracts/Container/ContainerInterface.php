<?php

namespace Framework\Contracts\Container;

use Framework\Container\ServiceNotFoundException;

interface ContainerInterface
{
    /**
     * @param string $id
     * @return mixed
     * @throws ServiceNotFoundException
     */
    public function get(string $id);

    public function has(string $id): bool;
}