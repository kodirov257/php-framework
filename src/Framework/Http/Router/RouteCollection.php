<?php

namespace Framework\Http\Router;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection as SymfonyRouteCollection;

class RouteCollection extends SymfonyRouteCollection
{
    public function add(string $name, Route $route, int $priority = 0): Route
    {
        parent::add($name, $route, $priority);

        return $route;
    }
}
