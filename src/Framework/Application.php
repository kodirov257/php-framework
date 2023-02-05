<?php

namespace Framework;

use DI\Definition\Source\MutableDefinitionSource;
use DI\Proxy\ProxyFactory;
use Framework\Container\Container;
use Framework\Contracts\Application as ApplicationContract;
use Psr\Container\ContainerInterface;

class Application extends Container implements ApplicationContract
{
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

    public function __construct(
        array|MutableDefinitionSource $definitions = [],
        ProxyFactory $proxyFactory = null,
        ContainerInterface $wrapperContainer = null,
        string $basePath = null
    ) {
        parent::__construct($definitions, $proxyFactory, $wrapperContainer);

        if ($basePath) {
            $this->setBasePath($basePath);
        }

        $this->registerBaseBindings();
        $this->registerCoreContainerAliases();
    }

    protected function registerBaseBindings(): void
    {
        static::setInstance($this);

        $this->registerInstance('app', $this);
    }

    private function registerCoreContainerAliases()
    {
        foreach ([
            'app' => \Framework\Contracts\Application::class,
            'configuration' => \Framework\Contracts\Config\Repository::class,
            'router' => \Framework\Http\Router\Router::class,
            'template' => \Framework\Contracts\Template\TemplateRenderer::class,
         ] as $alias => $abstract) {
            $this->alias($alias, $abstract);
        }
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
}