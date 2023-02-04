<?php

namespace App\Http\Controllers;

use DI\Attribute\Inject;
use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;
use Framework\Template\PhpRenderer;
use Laminas\Diactoros\Response\HtmlResponse;

class AboutController extends Controller
{
    #[Inject]
    private PhpRenderer $template;

    #[Get(name: 'about', uri: '/about')]
    public function index()
    {
        return new HtmlResponse($this->template->render('about'));
    }
}