<?php

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$request = ServerRequestFactory::fromGlobals();

### Action

$path = $request->getUri()->getPath();

if ($path === '/') {
    $name = $request->getQueryParams()['name'] ?? 'Guest';
    $response = (new HtmlResponse('Hello, ' . $name . '!'));
} elseif ($path === '/about') {
    $response = new HtmlResponse('I am a simple site');
} elseif ($path === '/blog') {
    $response = new JsonResponse([
        ['id' => 2, 'title' => 'Second Post'],
        ['id' => 1, 'title' => 'First Post'],
    ]);
} elseif (preg_match('#^/blog/(?P<id>\d+)$#i', $path, $matches)) {
    $id = $matches['id'];
    if ($id > 2) {
        $response = new JsonResponse(['error' => 'Undefined page']);
    } else {
        $response = new JsonResponse(['id' => $id, 'post' => 'Post #' . $id]);
    }
} else {
    $response = new HtmlResponse('Undefined page', 404);
}


### Postprocessing

$response = $response->withHeader('X-Developer', 'Abdurakhmon Kodirov');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);