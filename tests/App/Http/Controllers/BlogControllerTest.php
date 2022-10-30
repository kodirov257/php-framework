<?php

namespace Tests\App\Http\Controllers;

use App\Http\Controllers\BlogController;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;

class BlogControllerTest extends TestCase
{
    public function testIndexSuccess()
    {
        $controller = new BlogController();
        $response = $controller->index();

        self::assertEquals(200, $response->getStatusCode());
        self::assertJsonStringEqualsJsonString(json_encode([
            ['id' => 2, 'title' => 'The Second Post'],
            ['id' => 1, 'title' => 'The First Post'],
        ]), $response->getBody()->getContents());
    }

    public function testShowSuccess()
    {
        $controller = new BlogController();

        $request = (new ServerRequest())
            ->withAttribute('id', $id = 2);


        $response = $controller->show($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertJsonStringEqualsJsonString(
            json_encode(['id' => $id, 'title' => 'Post #' . $id]),
            $response->getBody()->getContents()
        );
    }

    public function testShowNotFound()
    {
        $controller = new BlogController();

        $request = (new ServerRequest())
            ->withAttribute('id', $id = 10);

        $response = $controller->show($request);

        self::assertEquals(404, $response->getStatusCode());
        self::assertEquals('Undefined page', $response->getBody()->getContents());
    }
}