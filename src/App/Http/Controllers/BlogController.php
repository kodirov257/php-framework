<?php

namespace App\Http\Controllers;

use App\ReadModel\PostReadRepository;
use Framework\Contracts\Template\TemplateRenderer;
use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class BlogController extends Controller
{
    private PostReadRepository $posts;
    private TemplateRenderer $template;

    public function __construct(PostReadRepository $posts, TemplateRenderer $template)
    {
        $this->posts = $posts;
        $this->template = $template;
    }

    #[Get(name: 'blog', uri: '/blog')]
    public function index()
    {
        $posts = $this->posts->getAll();
        return new HtmlResponse($this->template->render('app/blog/index', [
            'posts' => $posts,
        ]));
    }

    #[Get(name: 'blog_show', uri: '/blog/{id}', tokens: ['id' => '\d+'])]
    public function show(ServerRequestInterface $request)
    {
        if (!$post = $this->posts->find($request->getAttribute('id'))) {
            return new HtmlResponse('Undefined page', 404);
        }

        return new HtmlResponse($this->template->render('app/blog/show', [
            'post' => $post,
        ]));
    }
}