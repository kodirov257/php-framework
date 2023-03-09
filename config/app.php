<?php

return [
    /*
     * Application name
     */
    'name' => env('APP_NAME', 'Venkod'),

    /*
     * Application Timezone
     */
    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
     * Application Environment
     */
    'env' => env('APP_ENV', 'development'),

    /*
    | --------------------------------------------------------------
    | Application Routing Type
    | --------------------------------------------------------------
    |
    | This value determines which type of routing system to use.
    | Existing routing system types are "PHPFile" and "Attribute".
     */
    'route' => 'phpfile',

    /*
    | --------------------------------------------------------------
    | Autoloaded middlewares
    | --------------------------------------------------------------
    | The middlewares listed here will be automatically loaded on the
    | request to application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
     */
    'middlewares' => [
        App\Http\Middlewares\CredentialsMiddleware::class,
        App\Http\Middlewares\ProfilerMiddleware::class
    ],

    /*
    | --------------------------------------------------------------
    | Autoloaded containers
    | --------------------------------------------------------------
    | The containers listed here will be automatically loaded on the
    | request to application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
     */
    'containers' => [
        \App\Http\Middlewares\BasicAuthMiddleware::class,
        \Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware::class,
    ],

    'not_found_handler' => App\Http\Middlewares\NotFoundHandler::class,
];