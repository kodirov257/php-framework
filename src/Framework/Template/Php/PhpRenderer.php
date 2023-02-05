<?php

namespace Framework\Template\Php;

use Framework\Contracts\Template\TemplateRenderer;

class PhpRenderer implements TemplateRenderer
{
    private string $path;
    /* @var Extension[] $extensions */
    private array $extensions = [];
    private ?string $extend;
    private array $blocks = [];
    private \SplStack $blockNames;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->blockNames = new \SplStack();
    }

    public function addExtension(Extension $extension): void
    {
        $this->extensions[] = $extension;
    }

    public function render(string $name, array $params = []): string
    {
        $level = ob_get_level();
        $templateFile = $this->path . '/' . $name . '.php';
        $this->extend = null;

        try {
            ob_start();
            extract($params, EXTR_OVERWRITE);
            require $templateFile;
            $content = ob_get_clean();
        } catch (\Throwable|\Exception $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            $traces = $exception->getTrace();
            throw $e;
        }

        if (!$this->extend) {
            return $content;
        }

        return $this->render($this->extend);
    }

    public function extend(string $view): void
    {
        $this->extend = $view;
    }

    public function block(string $name, $content): void
    {
        if ($this->hasBlock($name)) {
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function ensureBlock(string $name): bool
    {
        if ($this->hasBlock($name)) {
            return false;
        }
        $this->beginBlock($name);
        return true;
    }

    public function beginBlock(string $name): void
    {
        $this->blockNames->push($name);
        ob_start();
    }

    public function endBlock(): void
    {
        $content = ob_get_clean();
        $name = $this->blockNames->pop();
        if ($this->hasBlock($name)) {
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function renderBlock(string $name): string
    {
        $block = $this->blocks[$name] ?? null;

        if ($block instanceof \Closure) {
            return $block();
        }
        return $block ?? '';
    }

    public function encode(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE);
    }

    private function hasBlock(string $name): bool
    {
        return array_key_exists($name, $this->blocks);
    }

    public function __call(string $name, array $arguments)
    {
        foreach ($this->extensions as $extension) {
            $functions = $extension->getFunctions();
            if (array_key_exists($name, $functions)) {
                return $functions[$name](...$arguments);
            }
        }
        throw new \InvalidArgumentException('Undefined function "' . $name . '"');
    }
}