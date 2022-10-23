<?php

use Framework\Http\Request;

chdir(dirname(__DIR__));
require 'src/Framework/Http/Request.php';

### Initialization

$request = new Request();

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';
header('X-Developer: Abdurakhmon Kodirov');
echo 'Hello, ' . $name . '!';