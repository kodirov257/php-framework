<?php

namespace App\Http\Controllers;

use App\ReadModel\Pagination;
use App\ReadModel\PostReadRepository;
use Framework\Http\Controller;
use Framework\Http\Router\Attributes\Get;
use Psr\Http\Message\ServerRequestInterface;

class BlogController extends Controller
{
    private const PER_PAGE = 5;
    private PostReadRepository $posts;

    public function __construct(PostReadRepository $posts)
    {
        $this->posts = $posts;
    }

    #[Get(name: 'blog', uri: '/blog')]
    public function index(ServerRequestInterface $request)
    {
        $pager = new Pagination(
            $this->posts->countAll(),
            $request->getAttribute('page') ?: 1,
            self::PER_PAGE
        );
        $posts = $this->posts->getAll(
            $pager->getOffset(),
            $pager->getLimit()
        );
        return view('app/blog/index', [
            'posts' => $posts,
            'pager' => $pager,
        ]);
    }

    #[Get(name: 'blog_page', uri: '/blog/page/{page}', tokens: ['page' => '\d+'])]
    public function indexPage(ServerRequestInterface $request)
    {
        return $this->index($request);
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
