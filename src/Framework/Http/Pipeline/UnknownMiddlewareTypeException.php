<?php

namespace Framework\Http\Pipeline;

class UnknownMiddlewareTypeException extends \InvalidArgumentException
{
    private mixed $type;

    public function __construct(mixed $type)
    {
        parent::__construct('Unknown middleware type');
        $this->type = $type;
    }

    public function getType(): mixed
    {
        return $this->type;
    }
}