<?php

namespace Framework\Http;

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Router;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class RouterTest extends TestCase
{
    public function testCorrectMethod1()
    {
        $router = new Router();

        $handlerGet = ['controller' => 'DefaultController', 'method' => 'handler_get'];
        $handlerPost = ['controller' => 'DefaultController', 'method' => 'handler_post'];

        $router->get($nameGet = 'blog', '/blog', [$handlerGet['controller'], $handlerGet['method']]);
        $router->post($namePost = 'blog_edit', '/blog', [$handlerPost['controller'], $handlerPost['method']]);

        $context = $this->buildRequestContext('GET', '/blog');
        $router->setContext($context);
        $result = $router->match($context->getPathInfo());
        self::assertEquals($nameGet, $result->getName());
        self::assertEquals($handlerGet, $result->getHandler());


        $context = $this->buildRequestContext('POST', '/blog');
        $router->setContext($context);
        $result = $router->match($context->getPathInfo());
        self::assertEquals($namePost, $result->getName());
        self::assertEquals($handlerPost, $result->getHandler());
    }

    public function testCorrectMethod2()
    {
        $router = new Router();

        $handlerGet = ['controller' => 'DefaultController', 'method' => 'handler_get'];
        $handlerPost = ['controller' => 'DefaultController', 'method' => 'handler_post'];

        $router->get($nameGet = 'blog', '/blog', $handlerGet);
        $router->post($namePost = 'blog_edit', '/blog', $handlerPost);

        $context = $this->buildRequestContext('GET', '/blog');
        $router->setContext($context);
        $result = $router->match($context->getPathInfo());
        self::assertEquals($nameGet, $result->getName());
        self::assertEquals($handlerGet, $result->getHandler());


        $context = $this->buildRequestContext('POST', '/blog');
        $router->setContext($context);
        $result = $router->match($context->getPathInfo());
        self::assertEquals($namePost, $result->getName());
        self::assertEquals($handlerPost, $result->getHandler());
    }

    public function testMissingMethod()
    {
        $router = new Router();

        $router->post('blog', '/blog', ['DefaultController', 'handler_post']);

        $this->expectException(RequestNotMatchedException::class);

        $context = $this->buildRequestContext('DELETE', '/blog');
        $router->setContext($context);
        $router->match($context->getPathInfo());
    }

    public function testMissingPath()
    {
        $router = new Router();

        $router->post('blog', '/blog', ['DefaultController', 'handler_post']);

        $this->expectException(RequestNotMatchedException::class);

        $context = $this->buildRequestContext('POST', '/blogs');
        $router->setContext($context);
        $router->match($context->getPathInfo());
    }

    public function testCorrectAttributes()
    {
        $router = new Router();

        $router->get($name = 'blog_show', '/blog/{id}', ['DefaultController', 'handler'], ['id' => '\d+']);

        $context = $this->buildRequestContext('GET', '/blog/5');
        $router->setContext($context);
        $result = $router->match($context->getPathInfo());

        self::assertEquals($name, $result->getName());
        self::assertEquals(['id' => '5'], $result->getAttributes());
    }

    public function testIncorrectAttributes()
    {
        $router = new Router();

        $router->get('blog_show', '/blog/{id}', ['DefaultController', 'handler'], ['id' => '\d+']);


        $this->expectException(RequestNotMatchedException::class);
        $context = $this->buildRequestContext('GET', '/blog/slug');
        $router->setContext($context);
        $router->match($context->getPathInfo());
    }

    public function testGenerate()
    {
        $router = new Router();

        $router->get('blog', '/blog', ['DefaultController', 'handler']);
        $router->get('blog_show', '/blog/{id}', ['DefaultController', 'handler'], ['id' => '\d+']);

        $context = $this->buildServerRequestContext(new ServerRequest());
        $router->setContext($context);


        self::assertEquals('/blog', $router->generate('blog'));
        self::assertEquals('/blog/5', $router->generate('blog_show', ['id' => 5]));
    }

    public function testGenerateMissingAttributes()
    {
        $router = new Router();

        $router->get('blog_show', '/blog/{id}', ['DefaultController', 'handler'], ['id' => '\d+']);

        $context = $this->buildServerRequestContext(new ServerRequest());
        $router->setContext($context);


        $this->expectException(\InvalidArgumentException::class);
        $router->generate('blog_show', ['slug' => 'post']);
    }

    private function buildRequestContext($method, $uri): RequestContext
    {
        $request = (new ServerRequest())
            ->withMethod($method)
            ->withUri(new Uri($uri));

        return $this->buildServerRequestContext($request);
    }

    private function buildServerRequestContext(ServerRequestInterface $request): RequestContext
    {
        return RequestContext::instance($request);
    }
}