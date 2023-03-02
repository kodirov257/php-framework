<?php

namespace App\Http\Middlewares\ErrorHandler;

use Framework\Contracts\Template\TemplateRenderer;
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
        $code = self::getStatusCode($e);
        return view($this->getView($code), [
            'request' => $request,
            'exception' => $e,
        ])->withStatus($code);
    }

    private static function getStatusCode(\Throwable $e): int
    {
        $code = $e->getCode();
        if ($code >= 400 && $code <= 600) {
            return $code;
        }
        return 500;
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