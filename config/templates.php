<?php

return [
    /*
    | --------------------------------------------------------------
    | Template system
    | --------------------------------------------------------------
    |
    | This value determines which type of template to use.
    |
     */

    'template' => 'twig',
    /*
    | --------------------------------------------------------------
    | Template default extension
    | --------------------------------------------------------------
    |
    | This value determines which type of view file extension to use.
    | As default template system is Twig, extension is ".html.twig".
    |
     */
    'extension' => '.html.twig',

    /*
    | --------------------------------------------------------------
    | Twig Template parameter
    | --------------------------------------------------------------
    |
    | The twig parameters listed here will be automatically loaded on
    | the request to application.
    |
     */
    'twig' => [
        'template_dir' => 'templates',
        'cache_dir' => 'var/cache/twig',
        'extensions' => [],
    ],
];