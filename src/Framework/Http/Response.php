<?php

namespace Framework\Http;

class Response implements ResponseInterface
{
    private array $headers = [];
    private mixed $body;
    private mixed $statusCode;
    private string $reasonPhrase = '';

    private static array $phrases = [
        200 => 'OK',
        301 => 'Moved Permanently',
        400 => 'Bad Request',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
    ];

    public function __construct(mixed $body, $status = 200)
    {
        $this->body = $body;
        $this->statusCode = $status;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function withBody(mixed $body): self
    {
        $new = clone $this;
        $new->body = $body;
        return $new;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getReasonPhrase(): string
    {
        if (!$this->reasonPhrase && isset(self::$phrases[$this->statusCode])) {
            $this->reasonPhrase = self::$phrases[$this->statusCode];
        }
        return $this->reasonPhrase;
    }

    public function withStatus(mixed $code, string $reasonPhrase = ''): self
    {
        $new = clone $this;
        $new->body = $code;
        $new->reasonPhrase = $reasonPhrase;
        return $new;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function hasHeader(string $header): bool
    {
        return isset($this->headers[$header]);
    }

    public function getHeader(string $header)
    {
        if (!$this->hasHeader($header)) {
            return null;
        }
        return $this->headers[$header];
    }

    public function withHeader(string $header, mixed $value): self
    {
        $new = clone $this;
        if ($new->hasHeader($header)) {
            unset($this->headers[$header]);
        }
        $new->headers[$header] = $value;
        return $new;
    }

}