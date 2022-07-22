<?php

return (new PhpCsFixer\Config)
    ->setRules([
        '@PhpCsFixer' => true,
        'phpdoc_no_empty_return' => false,
    ])
    ->setFinder(PhpCsFixer\Finder::create()->in(__DIR__));