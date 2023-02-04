<?php

namespace Tests\App\Http\Controllers;

use App\Http\Controllers\HelloController;
use Framework\Template\PhpRenderer;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;

class HelloControllerTest extends TestCase
{
    private PhpRenderer $renderer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->renderer = new PhpRenderer('templates');
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