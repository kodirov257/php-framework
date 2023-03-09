<?php

namespace App\Http\Controllers;

use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;

class AboutController extends Controller
{
    #[Get(name: 'about', uri: '/about')]
    public function index()
    {
        return view('app/about');
    }
}
