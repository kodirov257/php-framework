<?php

namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsRunFactory
{
    public function __invoke(): Run
    {
        $whoops = new Run();
        $whoops->allowQuit(false);
        $whoops->writeToOutput(false);
        $whoops->pushHandler(new PrettyPageHandler());
        $whoops->register();
        return $whoops;
    }
}
