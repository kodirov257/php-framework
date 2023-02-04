<?php

namespace App\Http\Controllers;

use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class HelloController extends Controller
{
    private TemplateRenderer $template;

    public function __construct(TemplateRenderer $template)
    {
        $this->template = $template;
    }

    #[Get(name: 'home', uri: '/')]
    public function index()
    {
        return new HtmlResponse($this->template->render('hello'));
    }
}