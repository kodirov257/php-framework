<?php

namespace Framework;

use Framework\Contracts\Application as ApplicationContract;

class ApplicationInfo implements ApplicationContract
{
    /**
     * The current globally available application (if any).
     *
     * @var static
     */
    protected static self $instance;

    /**
     * The application's shared instances
     *
     * @var object[]
     */
    private array $instances = [];

    /**
     * Framework version
     *
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     * The base path of the framework
     *
     * @var string
     */
    protected string $basePath;

    public function __construct(string $basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        $this->registerBaseBindings();
    }

    protected function registerBaseBindings(): void
    {
        static::setInstance($this);

        $this->registerInstance('app', $this);
    }

    public function getVersion(): string
    {
        return static::VERSION;
    }

    public function getBasePath(string $path = ''): string
    {
        return $this->basePath . ($path != '' ? DIRECTORY_SEPARATOR . $path : '');
    }

    public function getConfigPath(string $path = ''): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'config' . ($path != '' ? DIRECTORY_SEPARATOR . $path : '');
    }

    /**
     * Set the base path for the application
     *
     * @param string $basePath
     * @return $this
     */
    public function setBasePath(string $basePath): static
    {
        $this->basePath = rtrim($basePath, '\/');

        return $this;
    }

    public static function setInstance(ApplicationContract $application = null): ApplicationContract|static
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
        $this->instances[$abstract] = $instance;

        return $instance;
    }

    public function resolveInstance(string $abstract): mixed
    {
        return $this->instances[$abstract];
    }
}