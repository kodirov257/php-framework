<?php

namespace Framework\Config;

use Framework\Contracts\Config\Repository as ConfigContract;

class Repository implements ConfigContract
{
    private array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function has(string $key): bool
    {
        if (empty($this->items)) {
            return false;
        }

        $subKeyArray = $this->items;
        if (array_key_exists($key, $this->items)) {
            return true;
        }

        foreach (explode('.', $key) as $segment) {
            if (is_array($subKeyArray) && array_key_exists($segment, $subKeyArray)) {
                $subKeyArray = $subKeyArray[$segment];
            } else {
                return false;
            }
        }

        return true;
    }

    public function get(array|string $key, mixed $default = null): mixed
    {
        if (is_array($key)) {
            return $this->getMany($key);
        }

        return $this->getSingle($this->items, $key, $default);
    }

    private function getMany(array $keys): array
    {
        $config = [];
        foreach ($keys as $key => $default) {
            if (is_numeric($key)) {
                [$key, $default] = [$default, null];
            }

            $config[$key] = $this->getSingle($this->items, $key, $default);
        }

        return $config;
    }

    private static function getSingle(array $items, string|int|null $key, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return $items;
        }

        if (array_key_exists($key, $items)) {
            return $items[$key];
        }

        if (!str_contains($key, '.')) {
            return $items[$key] ?? value($default);
        }

        foreach (explode('.', $key) as $segment) {
            if (is_array($items) && array_key_exists($segment, $items)) {
                $items = $items[$segment];
            } else {
                return value($default);
            }
        }

        return $items;
    }

    public function set(array|string $key, mixed $value = null): void
    {
        $configs = is_array($key) ? $key : [$key => $value];

        foreach ($configs as $configName => $configValue) {
            $keys = explode('.', $configName);

            foreach ($keys as $i => $key) {
                if (count($keys) === 1) {
                    break;
                }

                unset($keys[$i]);

                if (!isset($this->items[$key]) || !is_array($this->items[$key])) {
                    $this->items[$key] = [];
                }

                $this->items = &$this->items[$key];
            }

            $this->items[array_shift($keys)] = $configValue;
        }
    }

    public function prepend(string $key, mixed $value): void
    {
        $array = $this->get($key, []);

        array_unshift($array, $value);

        $this->set($key, $array);
    }

    public function push(string $key, mixed $value): void
    {
        $array = $this->get($key, []);

        $array[] = $value;

        $this->set($key, $array);
    }

    public function all(): array
    {
        return $this->items;
    }
}
