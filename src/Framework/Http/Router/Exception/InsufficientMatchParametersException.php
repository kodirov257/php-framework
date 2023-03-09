<?php

namespace Framework\Http\Router\Exception;

class InsufficientMatchParametersException extends \LogicException
{
    private mixed $param;

    public function __construct(mixed $param)
    {
        parent::__construct('Match parameters are not valid.');
        $this->param = $param;
    }

    public function getParam(): mixed
    {
        return $this->param;
    }
}
