<?php

$header = <<<'EOF'
This file is part of the MopaBootstrapBundle.

(c) Philipp A. Mohrenweiser <phiamo@googlemail.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$finder = PhpCsFixer\Finder::create()
    ->exclude([
        'vendor',
    ])
    ->in(__DIR__)
;

return ($config = new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'header_comment' => ['header' => $header],
        'full_opening_tag' => false,
        'list_syntax' => ['syntax' => 'short'],
        'native_constant_invocation' => true,
        'native_function_invocation' => [
            'include' => ['@all'],
        ],
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;
