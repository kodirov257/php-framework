<?php

namespace Infrastructure\App\Console\Command;

use App\Console\Command\CacheClearCommand;
use App\Service\FileManager;
use Psr\Container\ContainerInterface;

class CacheClearCommandFactory
{
    public function __invoke(ContainerInterface $container): CacheClearCommand
    {
        return new CacheClearCommand(
            config('console.cachePaths'),
            $container->get(FileManager::class)
        );
    }
}