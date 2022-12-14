<?php

namespace App\Http\Controllers;

use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;
use Laminas\Diactoros\Response\HtmlResponse;

class AboutController extends Controller
{
    #[Get('about', '/about')]
    public function index()
    {
        return new HtmlResponse('I am a simple site');
    }
}