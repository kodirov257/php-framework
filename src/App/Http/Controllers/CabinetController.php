<?php

namespace App\Http\Controllers;

use App\Http\Middlewares\BasicAuthMiddleware;
use DI\Attribute\Inject;
use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;
use Framework\Http\Router\Attributes\Middleware;
use Framework\Template\PhpRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetController extends Controller
{
    #[Inject]
    private PhpRenderer $template;

    #[Get(name: 'cabinet', uri: '/cabinet')]
    #[Middleware(name: BasicAuthMiddleware::class)]
    public function index(ServerRequestInterface $request)
    {
        $username = $request->getAttribute(BasicAuthMiddleware::ATTRIBUTE);

        return new HtmlResponse($this->template->render('cabinet', [
            'name' => $username,
        ]));
    }
}