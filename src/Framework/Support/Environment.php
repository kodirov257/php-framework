<?php

namespace Framework\Support;

use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use Dotenv\Repository\RepositoryInterface;

class Environment
{

    protected static RepositoryInterface|null $repository = null;

    /**
     * Get the environment repository instance
     *
     * @return RepositoryInterface
     */
    public static function getRepository(): RepositoryInterface
    {
        if (static::$repository === null) {
            $builder = RepositoryBuilder::createWithDefaultAdapters();

            static::$repository = $builder->immutable()->make();
        }

        return static::$repository;
    }

    /**
     * Gets the value of an environment variable
     *
     * @param  string $key
     * @param  mixed|null $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $value = static::getRepository()->get($key);

        if (!$value) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
            return $matches[2];
        }

        return $value;
    }
}
