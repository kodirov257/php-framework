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

    public function test()
    {
        $controller = new HelloController($this->renderer);

        $request = new ServerRequest();
        $response = $controller->index();

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Hello!', $response->getBody()->getContents());
    }
}