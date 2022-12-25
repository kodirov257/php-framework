<?php

namespace Framework\Bootstrap\Config;

use Framework\Config\Repository;
use Framework\Contracts\Application;
use Framework\Contracts\Config\Repository as RepositoryContract;
use PHPUnit\Util\Exception;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class ConfigurationLoader
{
    public function bootstrap(Application $application): void
    {
        $application->registerInstance('config', $config = new Repository([]));

        $this->loadConfigurationFiles($application, $config);

        date_default_timezone_set($config->get('app.timezone', 'UTC'));

        mb_internal_encoding('UTF-8');
    }

    protected function loadConfigurationFiles(Application $application, RepositoryContract $repository): void
    {
        $files = $this->getConfigurationFiles($application);

        if (!isset($files['app'])) {
            throw new Exception('Cannot load main configuration file.');
        }

        foreach ($files as $key => $path) {
            $repository->set($key, require $path);
        }
    }

    protected function getConfigurationFiles(Application $application): array
    {
        $files = [];

        $configPath = realpath($application->getConfigPath());

        foreach (Finder::create()->files()->name('*.php')
                     ->notName('routes.php')
                     ->notName('container.php')
                     ->notName('pipeline.php')
                     ->in($configPath) as $file) {
            $directory = $this->getNestedDirectory($file, $configPath);

            $files[$directory . basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        ksort($files, SORT_NATURAL);

        return $files;
    }

    protected function getNestedDirectory(SplFileInfo $file, string $configPath): string
    {
        $directory = $file->getPath();

        if ($nested = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested) . '.';
        }

        return $nested;
    }
}