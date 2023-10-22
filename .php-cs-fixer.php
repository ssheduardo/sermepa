<?php

/**
 * @see https://cs.symfony.com/doc/config.html
 */
$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'static_lambda' => true,
        'void_return' => true,
        'ternary_to_null_coalescing' => true,
        'visibility_required' => true,
    ])
    ->setFinder($finder)
;
