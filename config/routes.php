<?php

use App\Http\Controllers;
use App\Http\Middlewares;
use Framework\Http\Router\Router;
use Framework\Http\Pipeline\Pipeline;
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
    $pipeline = new Pipeline();

    $pipeline->pipe(new Middlewares\ProfilerMiddleware());
    $pipeline->pipe(new Middlewares\BasicAuthMiddleware($params['users']));

    $cabinet = new Controllers\CabinetController();

    return $pipeline($request, function (ServerRequestInterface $request) use ($cabinet) {
        return $cabinet($request, 'index');
    });
});