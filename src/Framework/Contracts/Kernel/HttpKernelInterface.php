<?php

namespace Framework\Contracts\Kernel;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface HttpKernelInterface
{
    /**
     * Handles a Request to convert it to a Response.
     *
     * When $catch is true, the implementation must catch all exceptions
     * and do its best to convert them to a Response instance.
     *
     * @param ServerRequestInterface $request Request based on PSR7
     * @param bool $catch Whether to catch exceptions or not
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request, bool $catch = true): ResponseInterface;
}
