<?php

namespace Infrastructure\Framework\Http;

use Framework\Http\ActionResolver;
use Framework\Contracts\Application as ApplicationInterface;

class ActionResolverFactory
{
    public function __invoke(ApplicationInterface $container): ActionResolver
    {
        return new ActionResolver($container);
    }
}