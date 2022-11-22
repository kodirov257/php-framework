<?php

namespace Framework\Contracts\Http\Router;

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Exception\RouteNotFoundException;
use Framework\Http\Router\Result;
use Symfony\Component\Routing\Route;

interface Registrar
{
    /**
     * Add new GET route
     *
     * @param $name
     * @param $uri
     * @param $action
     * @param $tokens
     * @return Route
     */
    public function get($name, $uri, $action, $tokens): Route;

    /**
     * Add new POST route
     *
     * @param $name
     * @param $uri
     * @param $action
     * @param $tokens
     * @return Route
     */
    public function post($name, $uri, $action, $tokens): Route;

    /**
     * Add new PUT route
     *
     * @param $name
     * @param $uri
     * @param $action
     * @param $tokens
     * @return Route
     */
    public function put($name, $uri, $action, $tokens): Route;

    /**
     * Add new DELETE route
     *
     * @param $name
     * @param $uri
     * @param $action
     * @param $tokens
     * @return Route
     */
    public function delete($name, $uri, $action, $tokens): Route;

    /**
     * @param string $path
     * @throws RequestNotMatchedException
     * @return Result
     */
    public function match(string $path): Result;

    /**
     * @param string $name
     * @param array $params
     * @throws RouteNotFoundException|\InvalidArgumentException
     * @return string
     */
    public function generate(string $name, array $params = []): string;
}