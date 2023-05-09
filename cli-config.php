<?php

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Framework\Core;
use Symfony\Component\Console\Helper\DebugFormatterHelper;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\ProcessHelper;
use Symfony\Component\Console\Helper\QuestionHelper;

require __DIR__ . '/vendor/autoload.php';
$container = Core::InitializeContainer();
Core::SetConfiguration($container);
$ormConfig = $container->get('config')['orm'];
$config = $container->get('config')->set($ormConfig);

return new HelperSet([
    new FormatterHelper(),
    new DebugFormatterHelper(),
    new ProcessHelper(),
    new QuestionHelper(),
    'em' => new EntityManagerHelper($container->get(EntityManagerInterface::class)),
]);