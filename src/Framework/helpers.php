<?php

use Framework\Application;
use Framework\Support\Environment;

if (!function_exists('app')) {
    /**
     * @param string|null $abstract
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
     * @return mixed|Framework\Config\Repository
     */
    function config(array|string|null $key = null, mixed $default = null)
    {
        /* @var $config Framework\Config\Repository */
        $config = app('config');
        if (is_null($key)) {
            return $config;
        }

        if (is_array($key)) {
            return $config->set($key);
        }

        return $config->get($key, $default);
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

if (!function_exists('route')) {
    /**
     * Generates the URL to a named route
     *
     * @param string $name
     * @param array $params
     * @return string
     */
    function route(string $name, array $params = []): string
    {
        return app('router')->generate($name, $params);
    }
}

if (!function_exists('view')) {
    /**
     * Get the evaluated view contents for the given view
     *
     * @param string $view
     * @param array $data
     * @return Laminas\Diactoros\Response\HtmlResponse
     */
    function view(string $view, array $data = [])
    {
        /* @var $template Framework\Contracts\Template\TemplateRenderer */
        $template = app('template');
        return new \Laminas\Diactoros\Response\HtmlResponse($template->render($view, $data));
    }
}
