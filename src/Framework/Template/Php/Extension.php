<?php

namespace Framework\Template\Php;

abstract class Extension
{
    /**
     * @return ExtensionFunction[]
     */
    public function getFunctions(): array
    {
        return [];
    }
}