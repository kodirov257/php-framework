<?php

use Framework\Core;

require __DIR__.'/vendor/autoload.php';

$container = Core::InitializeContainer();
Core::SetConfiguration($container);

return [
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => 'development',
        'production' => [
            'name' => config('database.phinx.database'),
            'connection' => $container->get(PDO::class),
        ],
        'development' => [
            'name' => config('database.phinx.database'),
            'connection' => $container->get(PDO::class),
        ],
        'testing' => [
            'name' => config('database.phinx.database'),
            'connection' => $container->get(PDO::class),
        ]
    ],
    'paths' => [
        'migrations' => 'database/migrations',
        'seeds' => 'database/seeds',
    ],
    'version_order' => 'creation',
];
