<?php

namespace App\Http\Middlewares;

use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BasicAuthMiddleware implements MiddlewareInterface
{
    public const ATTRIBUTE = '_user';

    private array $users;
    private ResponseInterface $responsePrototype;

    public function __construct(array $users, ResponseInterface $responsePrototype)
    {
        $this->users = $users;
        $this->responsePrototype = $responsePrototype;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        if (!empty($username) && !empty($password)) {
            foreach ($this->users as $name => $pass) {
                if ($name === $username && $pass === $password) {
                    return $handler->handle($request->withAttribute(self::ATTRIBUTE, $username));
                }
            }
        }

        return $this->responsePrototype
            ->withStatus(401)
            ->withHeader('WWW-Authenticate', 'Basic realm=Restricted area');
    }
}
