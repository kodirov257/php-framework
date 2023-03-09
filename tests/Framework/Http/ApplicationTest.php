<?php

namespace Tests\Framework\Http;

use Framework\Http\HttpApplication;
use Framework\Http\MiddlewareResolver;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ApplicationTest extends TestCase
{
    private MiddlewareResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = new MiddlewareResolver(new DummyContainer(), new Response());
    }

    public function testPipe(): void
    {
        $app = new HttpApplication($this->resolver, new DefaultHandler());

        $app->pipe(new Middleware1());
        $app->pipe(new Middleware2());

        $response = $app->run(new ServerRequest());

        self::assertJsonStringEqualsJsonString(
            json_encode(['middleware-1' => 1, 'middleware-2' => 2]),
            $response->getBody()->getContents()
        );
    }
}

class Middleware1 implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request->withAttribute('middleware-1', 1));
    }
}

class Middleware2 implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request->withAttribute('middleware-2', 2));
    }
}

class DefaultHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse($request->getAttributes());
    }
}
