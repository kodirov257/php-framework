<?php

namespace Infrastructure\Framework\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

class LoggerFactory
{
    public function __invoke(ContainerInterface $container): Logger
    {
        $logger = new Logger('App');
        $logger->pushHandler(new StreamHandler(
            'var/log/application.log',
            config('parameters.debug') ? Logger::DEBUG : Logger::WARNING
        ));
        return $logger;
    }
}
