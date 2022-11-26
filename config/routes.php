<?php

use App\Http\Controllers;
use Framework\Http\Router\Router;

$params = [
    'users' => ['admin' => 'password'],
];

/** @var $router Router */
$router->get('home', '/', [Controllers\HelloController::class, 'index']);
$router->get('about', '/about', [Controllers\AboutController::class, 'index']);

$router->get('blog', '/blog', [Controllers\BlogController::class, 'index']);
$router->get('blog_show', '/blog/{id}', [Controllers\BlogController::class, 'show'], ['id' => '\d+']);

$router->get('cabinet', '/cabinet', [new Controllers\CabinetController($params['users']), 'index']);