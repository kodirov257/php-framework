<?php

namespace Framework\Http\Router\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class Route
{
    public function __construct(public string $name, public string $uri = '/', public $methods = ['GET'], public $tokens = [])
    {
    }
}
