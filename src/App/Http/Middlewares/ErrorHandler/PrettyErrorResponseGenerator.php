<?php

namespace App\Http\Middlewares\ErrorHandler;

use Framework\Contracts\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PrettyErrorResponseGenerator implements ErrorResponseGenerator
{
    private bool $debug;
    public function __construct(bool $debug)
    {
        $this->debug = $debug;
    }

    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        $view = $this->debug ? 'error/error-debug' : 'error/error';
        return view($view, [
            'request' => $request,
            'exception' => $e,
        ])->withStatus(self::getStatusCode($e));
    }

    private static function getStatusCode(\Throwable $e): int
    {
        $code = $e->getCode();
        if ($code >= 400 && $code <= 600) {
            return $code;
        }
        return 500;
    }
}