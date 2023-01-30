<?php

namespace Tests\App\Http\Controllers;

use App\Http\Controllers\HelloController;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;

class HelloControllerTest extends TestCase
{
    private TemplateRenderer $renderer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->renderer = new TemplateRenderer('templates');
    }

    public function testGuest()
    {
        $controller = new HelloController($this->renderer);

        $request = new ServerRequest();
        $response = $controller->index($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Hello, Guest!', $response->getBody()->getContents());
    }

    public function testJohn()
    {
        $controller = new HelloController($this->renderer);

        $request = (new ServerRequest())->withQueryParams(['name' => 'John']);

        $response = $controller->index($request);

        self::assertStringContainsString('Hello, John!', $response->getBody()->getContents());
    }
}