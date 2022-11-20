<?php

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$app = new Framework\Core();

$request = ServerRequestFactory::fromGlobals();

### Running

$response = $app->handle($request);

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);