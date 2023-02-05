<?php

namespace App\Http\Controllers;

use App\ReadModel\PostReadRepository;
use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;
use Psr\Http\Message\ServerRequestInterface;

class BlogController extends Controller
{
    private PostReadRepository $posts;

    public function __construct(PostReadRepository $posts)
    {
        $this->posts = $posts;
    }

    #[Get(name: 'blog', uri: '/blog')]
    public function index()
    {
        $posts = $this->posts->getAll();
        return view('app/blog/index', [
            'posts' => $posts,
        ]);
    }

    #[Get(name: 'blog_show', uri: '/blog/{id}', tokens: ['id' => '\d+'])]
    public function show(ServerRequestInterface $request)
    {
        if (!$post = $this->posts->find($request->getAttribute('id'))) {
            return view('error/404', [
                'request' => $request,
            ])->withStatus(404);
        }

        return view('app/blog/show', [
            'post' => $post,
        ]);
    }
}