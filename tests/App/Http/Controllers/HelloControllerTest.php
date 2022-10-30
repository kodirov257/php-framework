<?php

namespace Tests\App\Http\Controllers;

use App\Http\Controllers\HelloController;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;

class HelloControllerTest extends TestCase
{
    public function testGuest()
    {
        $controller = new HelloController();

        $request = new ServerRequest();
        $response = $controller->index($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('Hello, Guest!', $response->getBody()->getContents());
    }

    public function testJohn()
    {
        $controller = new HelloController();

        $request = (new ServerRequest())->withQueryParams(['name' => 'John']);

        $response = $controller->index($request);

        self::assertEquals('Hello, John!', $response->getBody()->getContents());
    }
}