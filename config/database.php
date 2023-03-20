<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */
    'database' => env('DB_CONNECTION', 'mysql'),

    'connections' => [
        'sqlite' => [
//        'dsn' => 'mysql:host=localhost;port=3306;dbname=app;charset=utf8mb4',
            'dsn' => env('DB_DSN', 'sqlite:database/db.sqlite'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ],
        ],
    ],
];