<?php

$changeSettings['SYS'] = [
  'displayErrors' => -1,
  'devIPmask' => '[your.IP.address]',
  'errorHandler' => 'TYPO3\\CMS\\Core\\Error\\ErrorHandler',
  'belogErrorReporting' => '0',
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $changeSettings);
