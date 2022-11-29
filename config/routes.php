<?php

use App\Http\Controllers;
use App\Http\Middlewares;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response\HtmlResponse;

/** @var $params array */
/** @var $router Router */
$router->get('home', '/', [Controllers\HelloController::class, 'index']);
$router->get('about', '/about', [Controllers\AboutController::class, 'index']);

$router->get('blog', '/blog', [Controllers\BlogController::class, 'index']);
$router->get('blog_show', '/blog/{id}', [Controllers\BlogController::class, 'show'], ['id' => '\d+']);

$router->get('cabinet', '/cabinet', [
    'middleware' => [new Middlewares\BasicAuthMiddleware($params['users'])],
    'action' => [Controllers\CabinetController::class, 'index'],
]);

$router->get('contact', '/contact', function () {
    return new HtmlResponse('Contact page.');
});