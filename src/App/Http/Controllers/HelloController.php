<?php

namespace App\Http\Controllers;

use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;

class HelloController extends Controller
{
    #[Get(name: 'home', uri: '/')]
    public function index()
    {
        return view('app/hello');
    }
}
