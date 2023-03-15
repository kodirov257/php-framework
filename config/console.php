<?php

use App\Console\Command\CacheClearCommand;

return [
    'commands' => [
        CacheClearCommand::class,
    ],
    'cachePaths' => [
        'twig' => 'var/cache/twig',
    ]
];