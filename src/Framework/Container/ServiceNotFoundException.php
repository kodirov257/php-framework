<?php

namespace Framework\Container;

use Framework\Contracts\Container\NotFoundExceptionInterface;

class ServiceNotFoundException extends \InvalidArgumentException implements NotFoundExceptionInterface
{

}