<?php

namespace Framework\Container;

use DI\Container as BaseContainer;
use Framework\Contracts\Container\Container as ContainerInterface;

class Container extends BaseContainer implements ContainerInterface
{
    /**
     * The current globally available container (if any).
     *
     * @var static
     */
    protected static self $instance;

    /**
     * The registered type aliases.
     *
     * @var string[]
     */
    protected array $aliases = [];

    public static function setInstance($application = null): static
    {
        return static::$instance = $application;
    }

    public static function getInstance(): static
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function registerInstance(string $abstract, mixed $instance): mixed
    {
        $abstract = $this->getAlias($abstract);
        $this->set($abstract, $instance);

        return $instance;
    }

    public function resolveInstance(string $abstract): mixed
    {
        $abstract = $this->getAlias($abstract);
        return $this->get($abstract);
    }

    public function alias(string $alias, string $abstract): void
    {
        if ($alias === $abstract) {
            throw new \LogicException("[{$abstract}] is aliased to itself");
        }

        $this->aliases[$alias] = $abstract;
    }

    public function getAlias(string $abstract): string
    {
        return $this->isAlias($abstract) ? $this->getAlias($this->aliases[$abstract]) : $abstract;
    }

    public function isAlias(string $name): bool
    {
        return isset($this->aliases[$name]);
    }
}