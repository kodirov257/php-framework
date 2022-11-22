<?php

namespace Framework\Http\Router\Exception;

class RequestNotMatchedException extends \LogicException
{
    private string $path;

    public function __construct(string $path)
    {
        parent::__construct('Matches not found.');
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}