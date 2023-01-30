<?php

namespace Framework\Template;

class TemplateRenderer
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function render(string $view, array $params = []): string
    {
        $templateFile = $this->path . '/' . $view . '.php';

        ob_start();
        extract($params, EXTR_OVERWRITE);
        require $templateFile;
        return ob_get_clean();
    }
}