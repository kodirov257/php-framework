<?php

namespace App\Http\Controllers;

use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;
use Framework\Template\PhpRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class HelloController extends Controller
{
    private PhpRenderer $template;

    public function __construct(PhpRenderer $template)
    {
        $this->template = $template;
    }

    #[Get(name: 'home', uri: '/')]
    public function index()
    {
        return new HtmlResponse($this->template->render('hello'));
    }
}