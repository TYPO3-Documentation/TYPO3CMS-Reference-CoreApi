<?php

$config = \TYPO3\CodingStandards\CsFixerConfig::create();
$config
    ->getFinder()->in(__DIR__)
;

$config->addRules([
    'no_useless_else' => false, // We want to preserve else with only comments
]);

return $config;
