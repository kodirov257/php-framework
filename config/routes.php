<?php

use App\Http\Controllers;
use App\Http\Middlewares;
use Framework\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;

$params = [
    'users' => ['admin' => 'password'],
];

/** @var $router Router */
$router->get('home', '/', [Controllers\HelloController::class, 'index']);
$router->get('about', '/about', [Controllers\AboutController::class, 'index']);

$router->get('blog', '/blog', [Controllers\BlogController::class, 'index']);
$router->get('blog_show', '/blog/{id}', [Controllers\BlogController::class, 'show'], ['id' => '\d+']);

$router->get('cabinet', '/cabinet', function (ServerRequestInterface $request) use ($params) {
    $profiler = new Middlewares\ProfilerMiddleware();
    $auth = new Middlewares\BasicAuthMiddleware($params['users']);
    $cabinet = new Controllers\CabinetController();

    return $profiler($request, function (ServerRequestInterface $request) use ($auth, $cabinet) {
        return $auth($request, function (ServerRequestInterface $request) use ($cabinet) {
            return $cabinet($request, 'index');
        });
    });
});