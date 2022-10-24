<?php

namespace Framework\Http;

interface ResponseInterface
{
    public function getBody();

    /**
     * @param mixed $body
     * @return static
     */
    public function withBody(mixed $body): self;

    public function getStatusCode();

    public function getReasonPhrase(): string;

    /**
     * @param mixed $code
     * @param string $reasonPhrase
     * @return static
     */
    public function withStatus(mixed $code, string $reasonPhrase = ''): self;

    public function getHeaders(): array;

    public function hasHeader(string $header): bool;

    public function getHeader(string $header);

    /**
     * @param string $header
     * @param mixed $value
     * @return static
     */
    public function withHeader(string $header, mixed $value): self;
}