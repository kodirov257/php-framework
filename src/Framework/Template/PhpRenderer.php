<?php

namespace Framework\Template;

use Framework\Contracts\Template\TemplateRenderer;

class PhpRenderer implements TemplateRenderer
{
    private string $path;
    private ?string $extend;
    private array $params = [];

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function render(string $name, array $params = []): string
    {
        $templateFile = $this->path . '/' . $name . '.php';

        ob_start();
        extract($params, EXTR_OVERWRITE);
        $this->extend = null;
        require $templateFile;
        $content = ob_get_clean();

        if (!$this->extend) {
            return $content;
        }

        return $this->render($this->extend, [
            'content' => $content,
        ]);
    }

    public function extend(string $view): void
    {
        $this->extend = $view;
    }
}