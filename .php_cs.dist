<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'full_opening_tag' => false,
        'yoda_style' => false,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;
