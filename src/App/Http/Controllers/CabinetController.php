<?php

namespace App\Http\Controllers;

use Framework\Http\Router\Attributes\Get;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetController
{
    private array $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    #[Get('cabinet', '/cabinet')]
    public function index(ServerRequestInterface $request)
    {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        if (!empty($username) && !empty($password)) {
            foreach ($this->users as $name => $pass) {
                if ($name === $username && $pass === $password) {
                    return new HtmlResponse('I am logged in as ' . $username);
                }
            }
        }

        return new EmptyResponse(401, ['WWW-Authenticate' => 'Basic realm=Restricted area']);
    }
}