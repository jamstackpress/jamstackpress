<?php

return (new PhpCsFixer\Config)
    ->setRules(['@PhpCsFixer' => true])
    ->setFinder(PhpCsFixer\Finder::create()->in(__DIR__));