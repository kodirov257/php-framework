<?php

namespace Framework\Http;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\RequestContext as SymfonyRequestContext;

class RequestContext extends SymfonyRequestContext
{
    public static function instance(ServerRequestInterface $request): static
    {
        $symfonyRequest = RequestAdaptor::getSymfonyRequest($request);

        $context = new static();
        $context->fromRequest($symfonyRequest);

        return $context;
    }
}
