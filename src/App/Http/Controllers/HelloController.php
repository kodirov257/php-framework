<?php

namespace App\Http\Controllers;

use Framework\Http\Router\Attributes\Get;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class HelloController
{
    #[Get('home', '/')]
    public function index(ServerRequestInterface $request)
    {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new HtmlResponse('Hello, ' . $name . '!');
    }
}