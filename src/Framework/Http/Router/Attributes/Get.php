<?php

namespace Framework\Http\Router\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class Get extends Route
{
    public function __construct(public string $name, public string $uri = '/', public $tokens = [])
    {
        parent::__construct($name, $uri, ['GET'], $this->tokens);
    }
}
