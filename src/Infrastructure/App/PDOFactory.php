<?php

namespace Infrastructure\App;

use Psr\Container\ContainerInterface;

class PDOFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbConnection = config('database.database');
        $config = config('database.connections.' . $dbConnection);

        return new \PDO(
            $config['dsn'],
            $config['username'],
            $config['password'],
            $config['options'],
        );
    }
}