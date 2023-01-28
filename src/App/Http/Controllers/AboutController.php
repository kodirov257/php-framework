<?php

namespace App\Http\Controllers;

use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;
use Laminas\Diactoros\Response\HtmlResponse;

class AboutController extends Controller
{
    #[Get(name: 'about', uri: '/about')]
    public function index()
    {
        return new HtmlResponse('I am a simple site');
    }
}