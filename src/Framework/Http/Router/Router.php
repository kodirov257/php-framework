<?php

namespace Framework\Http\Router;

use Framework\Contracts\Http\Router\Registrar;
use Framework\Http\RequestContext;
use Framework\Http\Router\Attributes;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException as SymfonyRouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Route;

class Router implements Registrar
{
    const PHPFILE_TYPE = 'phpfile';
    const ATTRIBUTE_TYPE = 'attribute';

    private RouteCollection $routes;
    private ?RequestContext $context;

    public static array $verbs = ['GET', 'POST', 'PUT', 'DELETE'];

    public function __construct(RequestContext $context = null)
    {
        $this->routes = new RouteCollection;
        $this->context = $context;
    }

    public function addRoute($name, Route $route): Route
    {
        return $this->routes->add($name, $route);
    }

    public function registerRoutesFromAttributes(array $controllers): void
    {
        foreach ($controllers as $controller) {
            $reflectionController = new \ReflectionClass($controller);

            foreach ($reflectionController->getMethods() as $method) {
                $attributes = $method->getAttributes(Attributes\Route::class, \ReflectionAttribute::IS_INSTANCEOF);

                foreach ($attributes as $attribute) {
                    /* @var $route Attributes\Route */
                    $route = $attribute->newInstance();

                    $this->add($route->name, $route->uri, [$method->getDeclaringClass()->getName(), $method->getName()], $route->methods, $route->tokens);
                }
            }
        }

    }

    public function add($name, $uri, $action, array $methods, array $tokens = []): Route
    {
        return $this->addRoute($name, (new Route($uri, $action, $tokens))->setMethods($methods));
    }

    public function get($name, $uri, $action, $tokens = []): Route
    {
        return $this->add($name, $uri, $action, ['GET'], $tokens);
    }

    public function post($name, $uri, $action, $tokens = []): Route
    {
        return $this->add($name, $uri, $action, ['POST'], $tokens);
    }

    public function put($name, $uri, $action, $tokens = []): Route
    {
        return $this->add($name, $uri, $action, ['PUT'], $tokens);
    }

    public function delete($name, $uri, $action, $tokens = []): Route
    {
        return $this->add($name, $uri, $action, ['DELETE'], $tokens);
    }

    public function any(string $name, $uri, $action, $tokens = []): Route
    {
        return $this->add($name, $uri, $action, self::$verbs, $tokens);
    }

    public function match(string $path): Result
    {
        $matcher = new UrlMatcher($this->routes, $this->context);
        try {
            $parameters = $matcher->match($path);

            $handler = [];
            $routeName = '';
            $attributes = [];
            foreach ($parameters as $key => $parameter) {
                if (!\is_int($key)) {
                    if ($key === 'controller') {
                        $handler['controller'] = $parameter;
                    } else if ($key === 'method') {
                        $handler['method'] = $parameter;
                    } else if ($key === '_route') {
                        $routeName = $parameter;
                    } else {
                        $attributes[$key] = $parameter;
                    }
                } elseif (is_object($parameter) && strpos(get_class($parameter), 'Controller')) {
                    $handler['controller'] = $parameter;
                } else {
                    if (strpos($parameter, 'Controller')) {
                        $handler['controller'] = $parameter;
                    } else {
                        $handler['method'] = $parameter;
                    }
                }

            }

            return new Result($routeName, $handler, $attributes);
        } catch (ResourceNotFoundException|MethodNotAllowedException $e) {
            throw new RequestNotMatchedException($path);
        }
    }

    public function generate(string $name, array $params = []): string
    {
        $generator = new UrlGenerator($this->routes, $this->context);
        try {
            return $generator->generate($name, $params);
        } catch (SymfonyRouteNotFoundException $e) {
            throw new RouteNotFoundException($name, $params, $e);
        }
    }

    public function setContext(RequestContext $context): void
    {
        $this->context = $context;
    }
}