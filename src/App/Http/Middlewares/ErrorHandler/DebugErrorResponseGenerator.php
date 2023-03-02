<?php

namespace App\Http\Middlewares\ErrorHandler;

use Framework\Contracts\Template\TemplateRenderer;
use Laminas\Diactoros\Response;
use Laminas\Stratigility\Utils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DebugErrorResponseGenerator implements ErrorResponseGenerator
{
    private TemplateRenderer $template;
    private ResponseInterface $response;
    private string $view;

    public function __construct(TemplateRenderer $template, ResponseInterface $response, string $view)
    {
        $this->template = $template;
        $this->response = $response;
        $this->view = $view;
    }

    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->response->withStatus(Utils::getStatusCode($e, $this->response));

        $response
            ->getBody()
            ->write($this->template->render($this->view, [
                'request' => $request,
                'exception' => $e,
            ]));

        return $response;
    }
}