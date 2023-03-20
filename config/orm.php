<?php

return [
    'name' => 'doctrine',

    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driver_class' => Doctrine\DBAL\Driver\PDO\SQLite\Driver::class,
                'pdo' => PDO::class,
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => Doctrine\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [
                    'App\Entity' => 'entities',
                ],
            ],
            'entities' => [
                'class' => Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => ['src/App/Entity'],
            ],
        ],
    ],
];