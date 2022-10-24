<?php

namespace Framework\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

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
        $this->body = $body instanceof StreamInterface ? $body : new Stream($body);
        $this->statusCode = $status;
    }

    public function getBody(): StreamInterface
    {
        return $this->body;
    }

    public function withBody(StreamInterface $body): self
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

    public function withStatus(mixed $code, $reasonPhrase = ''): self
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

    public function hasHeader($name): bool
    {
        return isset($this->headers[$name]);
    }

    public function getHeader($name)
    {
        if (!$this->hasHeader($name)) {
            return null;
        }
        return $this->headers[$name];
    }

    public function withHeader($name, $value): self
    {
        $new = clone $this;
        if ($new->hasHeader($name)) {
            unset($this->headers[$name]);
        }
        $new->headers[$name] = (array)$value;
        return $new;
    }

    public function withAddedHeader($name, $value): self
    {
        $new = clone $this;
        $new->headers[$name] = array_merge($new->headers[$name], (array)$value);
        return $new;
    }

    public function withoutHeader($name): self
    {
        $new = clone $this;
        if ($new->hasHeader($name)) {
            unset($this->headers[$name]);
        }
        return $new;
    }

    public function getProtocolVersion() {}
    public function withProtocolVersion($version) {}
    public function getHeaderLine($name) {}
}