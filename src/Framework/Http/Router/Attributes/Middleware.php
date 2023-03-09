<?php

namespace Framework\Http\Router\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class Middleware
{
    public function __construct(public string $name, public mixed $value = null)
    {
    }
}
