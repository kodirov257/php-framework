<?php

namespace App\Http\Middlewares\ErrorHandler;

use Laminas\Diactoros\Response;
use Laminas\Stratigility\Utils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DebugErrorResponseGenerator implements ErrorResponseGenerator
{
    private string $view;
    public function __construct(string $view)
    {
        $this->view = $view;
    }

    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        return view($this->view, [
            'request' => $request,
            'exception' => $e,
        ])->withStatus(Utils::getStatusCode($e, new Response()));
    }
}