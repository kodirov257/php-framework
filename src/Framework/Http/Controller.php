<?php

namespace Framework\Http;

use BadMethodCallException;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

abstract class Controller
{
    /**
     * Used when called next function
     *
     * @param string $method
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function __invoke(ServerRequestInterface $request, string $method): Response
    {
        return $this->callAction($method, $request);
    }

    /**
     * Run an action on the controller
     *
     * @param string $method
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function callAction(string $method, ServerRequestInterface $request): Response
    {
        return $this->{$method}($request);
    }

    /**
     * Handle calls when method is missed on the controller
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call(string $method, array $parameters): mixed
    {
        throw new BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $method));
    }
}