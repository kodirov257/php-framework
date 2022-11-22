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
];