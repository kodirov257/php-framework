<?php

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions(require __DIR__ . '/dependencies.php');

/* @var $container DI\Container */
$container = $builder->build();

$container->set('config', require __DIR__ . '/parameters.php');

return $container;