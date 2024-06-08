<?php

$config = \TYPO3\CodingStandards\CsFixerConfig::create();
$baseDir = __DIR__ . '/../../';
$config->getFinder()
    ->in($baseDir . 'config')
    ->in($baseDir . 'packages/*/Classes')
    ->in($baseDir . 'packages/*/Configuration')
    ->in($baseDir . 'packages/*/Tests')
    ->in($baseDir . 'packages/*.php')
    ->in($baseDir . 'Tests')
    ->exclude('Fixtures')
;
return $config;
