<?php

namespace App\Http\Controllers;

use DI\Attribute\Inject;
use Framework\Contracts\Template\TemplateRenderer;
use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;
use Laminas\Diactoros\Response\HtmlResponse;

class AboutController extends Controller
{
    #[Inject]
    private TemplateRenderer $template;

    #[Get(name: 'about', uri: '/about')]
    public function index()
    {
        return new HtmlResponse($this->template->render('app/about'));
    }
}