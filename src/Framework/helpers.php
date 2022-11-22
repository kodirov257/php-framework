<?php

use Framework\Application;
use Framework\Support\Environment;

if (!function_exists('app')) {
    /**
     * @param string|null $abstract
     * @param array $parameters
     * @return mixed|Application
     */
    function app(string|null $abstract = null)
    {
        if (is_null($abstract)) {
            return Application::getInstance();
        }

        return Application::getInstance()->resolveInstance($abstract);
    }
}

if (!function_exists('config')) {
    /**
     * Gets or sets the specified configuration value.
     *
     * @param array|string|null $key
     * @param mixed $default
     * @return mixed|\Framework\Config\Repository
     */
    function config(array|string|null $key = null, mixed $default = null)
    {
        if (is_null($key)) {
            return app('config');
        }

        if (is_array($key)) {
            return app('config')->set($key);
        }

        return app('config')->get($key, $default);
    }
}

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    function env(string $key, mixed $default = null): mixed
    {
        return Environment::get($key, $default);
    }
}

if (!function_exists('value')) {
    /**
     * Return the default value of the given value
     *
     * @param mixed $value
     * @param mixed ...$args
     * @return mixed
     */
    function value(mixed $value, ...$args): mixed
    {
        return $value instanceof Closure ? $value(...$args) : $value;
    }
}