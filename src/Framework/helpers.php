<?php

use Framework\Application;

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