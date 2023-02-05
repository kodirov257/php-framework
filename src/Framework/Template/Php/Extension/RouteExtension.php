<?php

namespace Framework\Template\Php\Extension;

use Framework\Http\Router\Router;
use Framework\Template\Php\Extension;

class RouteExtension extends Extension
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            'path' => [$this, 'generatePath'],
        ];
    }

    public function generatePath(string $name, array $params = []): string
    {
        return $this->router->generate($name, $params);
    }
}