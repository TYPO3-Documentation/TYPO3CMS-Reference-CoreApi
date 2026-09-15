<?php

$GLOBALS['TYPO3_CONF_VARS']['SYS']['yamlLoader']['placeholderProcessors']
    [\Vendor\MyExtension\PlaceholderProcessor\CustomPlaceholderProcessor::class] = [
      'before' => [
        \TYPO3\CMS\Core\Configuration\Processor\Placeholder\ValueFromReferenceArrayProcessor::class,
      ],
      'after' => [
        \TYPO3\CMS\Core\Configuration\Processor\Placeholder\EnvVariableProcessor::class,
      ],
      'disabled' => false,
    ];
