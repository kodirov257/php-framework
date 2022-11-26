<?php

namespace App\Http\Controllers;

use Framework\Http\Router\Attributes\Get;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetController
{
    #[Get('cabinet', '/cabinet')]
    public function index(ServerRequestInterface $request)
    {
        return new HtmlResponse('Cabinet.');
    }
}