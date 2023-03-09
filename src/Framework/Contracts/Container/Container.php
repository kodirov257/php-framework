<?php

namespace Framework\Contracts\Container;

use Framework\Contracts\Application;
use Psr\Container\ContainerInterface;

interface Container extends ContainerInterface
{

    /**
     * Set application instance.
     *
     * @param Application|Container|null $application
     * @return static
     */
    public static function setInstance(Container|Application $application = null): self|static;

    /**
     * Get the application instance.
     *
     * @return static
     */
    public static function getInstance(): static;

    /**
     * Register instance to container.
     *
     * @param string $abstract
     * @param mixed $instance
     * @return mixed
     */
    public function registerInstance(string $abstract, mixed $instance): mixed;

    /**
     * Get the instance from container.
     *
     * @param string $abstract
     * @return mixed
     */
    public function resolveInstance(string $abstract): mixed;
    /**
     * Alias a type to a different name.
     *
     * @param string $abstract
     * @param string $alias
     * @return void
     *
     * @throws \LogicException
     */
    public function alias(string $abstract, string $alias): void;
}
