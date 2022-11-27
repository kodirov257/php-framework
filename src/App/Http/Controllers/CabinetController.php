<?php

namespace App\Http\Controllers;

use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetController extends Controller
{
    #[Get('cabinet', '/cabinet')]
    public function index(ServerRequestInterface $request)
    {
        $username = $request->getAttribute('username');

        return new HtmlResponse('I am logged in as ' . $username);
    }
}