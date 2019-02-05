<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->notPath('bootstrap/*')
    ->notPath('storage/*')
    ->notPath('vendor')
    ->in([
        __DIR__ . '/app/',
        __DIR__ . '/tests',
        __DIR__ . '/database',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);


return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,

        'array_syntax' => ['syntax' => 'short'],
        'trailing_comma_in_multiline_array' => true,

        'ordered_imports' => ['sortAlgorithm' => 'alpha'],
        'no_unused_imports' => true,

        'unary_operator_spaces' => true,
        'binary_operator_spaces' => true,
        'cast_spaces' => true,
        'not_operator_with_successor_space' => true,


        'blank_line_before_statement' => [
            'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
        ],

        'phpdoc_scalar' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_var_without_name' => true,

        'class_attributes_separation' => [
            'elements' => [
                'method', 'property',
            ],
        ],
        'visibility_required' => ['property', 'method'],

        'void_return' => true,

        'explicit_string_variable' => true,
    ])
    ->setFinder($finder);
