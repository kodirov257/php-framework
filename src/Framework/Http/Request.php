<?php

namespace Framework\Http;

class Request
{
    private array $queryParams = [];
    private mixed $parsedBody = null;

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function withQueryParams(array $query): void
    {
        $this->queryParams = $query;
    }

    public function getParsedBody(): ?array
    {
        return $this->parsedBody;
    }

    public function withParsedBody(array $data): void
    {
        $this->parsedBody = $data;
    }
}