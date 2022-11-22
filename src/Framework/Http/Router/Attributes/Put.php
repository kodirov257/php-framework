<?php

namespace Framework\Http\Router\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class Put extends Route
{
    public function __construct(public string $name, public string $uri = '/', public $tokens = [])
    {
        parent::__construct($name, $uri, ['PUT'], $this->tokens);
    }
}