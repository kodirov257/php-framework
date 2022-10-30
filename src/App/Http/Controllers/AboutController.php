<?php

namespace App\Http\Controllers;

use Laminas\Diactoros\Response\HtmlResponse;

class AboutController
{
    public function index()
    {
        return new HtmlResponse('I am a simple site');
    }
}