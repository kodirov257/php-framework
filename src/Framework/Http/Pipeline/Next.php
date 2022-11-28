<?php

namespace Framework\Http\Pipeline;

use Psr\Http\Message\ServerRequestInterface;

class Next
{
    private \SplQueue $queue;
    private $next;

    public function __construct(\SplQueue $queue, callable $next)
    {
        $this->queue = $queue;
        $this->next = $next;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($this->queue->isEmpty()) {
            return ($this->next)($request);
        }

        $middleware = $this->queue->dequeue();

        return $middleware($request, function (ServerRequestInterface $request) {
            return $this($request);
        });
    }
}