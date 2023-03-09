<?php

namespace Framework\Contracts\Template;

interface TemplateRenderer
{
    public function render(string $name, array $params = []): string;
}
