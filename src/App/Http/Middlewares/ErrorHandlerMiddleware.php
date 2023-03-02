<?php

namespace App\Http\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    private bool $debug;

    public function __construct(bool $debug)
    {
        $this->debug = $debug;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            $view = $this->debug ? 'error/error-debug' : 'error/error';
            return view($view, [
                'request' => $request,
                'exception' => $e,
            ])->withStatus(self::getStatusCode($e));
        }
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