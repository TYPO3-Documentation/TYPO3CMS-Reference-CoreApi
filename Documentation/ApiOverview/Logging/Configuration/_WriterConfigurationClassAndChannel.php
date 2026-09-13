<?php

// Configure logging ...

// For class \T3docs\Examples\Controller\FalExampleController
$GLOBALS['TYPO3_CONF_VARS']['LOG']
    ['T3docs']['Examples']['Controller']['FalExampleController']
    ['writerConfiguration'] = [
      // ...
    ];

// For channel "security"
$GLOBALS['TYPO3_CONF_VARS']['LOG']['security']['writerConfiguration'] = [
  // ...
];
