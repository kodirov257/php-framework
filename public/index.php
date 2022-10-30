<?php

use App\Http\Controllers;
use Framework\Http\ActionResolver;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\SimpleRouter;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$routes = new RouteCollection();

$routes->get('home', '/', [Controllers\HelloController::class, 'index']);
$routes->get('about', '/about', [Controllers\AboutController::class, 'index']);
$routes->get('blog', '/blog', [Controllers\BlogController::class, 'index']);
$routes->get('blog_show', '/blog/{id}', [Controllers\BlogController::class, 'show'], ['id' => '\d+']);

$router = new SimpleRouter($routes);
$resolver = new ActionResolver();

### Running

$request = ServerRequestFactory::fromGlobals();

try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $response = $resolver->resolve($result->getHandler(), $request);
} catch (RequestNotMatchedException $e) {
    $response = new HtmlResponse('Undefined page', 404);
}

### Postprocessing

$response = $response->withHeader('X-Developer', 'Abdurakhmon Kodirov');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);