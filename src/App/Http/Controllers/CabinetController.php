<?php

namespace App\Http\Controllers;

use App\Http\Middlewares\BasicAuthMiddleware;
use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;
use Framework\Http\Router\Attributes\Middleware;
use Psr\Http\Message\ServerRequestInterface;

class CabinetController extends Controller
{
    #[Get(name: 'cabinet', uri: '/cabinet')]
    #[Middleware(name: BasicAuthMiddleware::class)]
    public function index(ServerRequestInterface $request)
    {
        $username = $request->getAttribute(BasicAuthMiddleware::ATTRIBUTE);

        return view('app/cabinet', [
            'name' => $username,
        ]);
    }
}
