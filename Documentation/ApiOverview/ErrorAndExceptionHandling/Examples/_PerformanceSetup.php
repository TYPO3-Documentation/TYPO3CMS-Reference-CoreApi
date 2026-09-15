<?php

$changeSettings['SYS'] = [
  'displayErrors' => 0,
  'devIPmask' => '',
  'errorHandler' => '',
  'debugExceptionHandler' => '',
  'productionExceptionHandler' => '',
  'belogErrorReporting' => '0',
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $changeSettings);
