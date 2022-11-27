<?php

namespace App\Http\Controllers;

use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ServerRequestInterface;

class BasicAuthControllerDecorator
{
    private object $next;
    private array $users;
    private string $method;

    public function __construct(object $next, array $users, string $method)
    {
        $this->next = $next;
        $this->users = $users;
        $this->method = $method;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        if (!empty($username) && !empty($password)) {
            foreach ($this->users as $name => $pass) {
                if ($name === $username && $pass === $password) {
                    return ($this->next)($this->method, $request->withAttribute('username', $username));
                }
            }
        }

        return new EmptyResponse(401, ['WWW-Authenticate' => 'Basic realm=Restricted area']);
    }
}