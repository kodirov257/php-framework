<?php

namespace Framework\Contracts;

use Framework\Contracts\Container\Container;

interface Application extends Container
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
}