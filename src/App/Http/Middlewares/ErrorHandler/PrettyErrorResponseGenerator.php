<?php

namespace App\Http\Middlewares\ErrorHandler;

use Laminas\Diactoros\Response;
use Laminas\Stratigility\Utils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PrettyErrorResponseGenerator implements ErrorResponseGenerator
{
    private array $views;
    public function __construct(array $views)
    {
        $this->views = $views;
    }

    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        $code = Utils::getStatusCode($e, new Response());
        return view($this->getView($code), [
            'request' => $request,
            'exception' => $e,
        ])->withStatus($code);
    }

    private function getView(int $code): string
    {
        if (array_key_exists($code, $this->views)) {
            $view = $this->views[$code];
        } else {
            $view = $this->views['error'];
        }
        return $view;
    }
}