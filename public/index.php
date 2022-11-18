<?php

use App\Http\Controllers;
use Framework\Http\ActionResolver;
use Framework\Http\RequestContext;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$router = new Router();

$router->get('home', '/', [Controllers\HelloController::class, 'index']);
$router->get('about', '/about', [Controllers\AboutController::class, 'index']);
$router->get('blog', '/blog', [Controllers\BlogController::class, 'index']);
$router->get('blog_show', '/blog/{id}', [Controllers\BlogController::class, 'show'], ['id' => '\d+']);

$resolver = new ActionResolver();

### Running

$request = ServerRequestFactory::fromGlobals();

try {
    $context = RequestContext::instance($request);
    $router->setContext($context);

    $result = $router->match($request->getUri()->getPath());

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