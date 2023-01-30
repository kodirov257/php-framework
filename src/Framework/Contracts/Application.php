<?php

namespace Framework\Contracts;

use Psr\Container\ContainerInterface;

interface Application extends ContainerInterface
{
    /**
     * Get the version of framework
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Get the base path of the Framework installation.
     *
     * @param  string $path
     * @return string
     */
    public function getBasePath(string $path = ''): string;

    /**
     * Get the path to the configuration files.
     *
     * @param string $path
     * @return string
     */
    public function getConfigPath(string $path = ''): string;

    /**
     * Set application instance.
     *
     * @param Application|null $application
     * @return static
     */
    public static function setInstance(self $application = null): self|static;

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
}