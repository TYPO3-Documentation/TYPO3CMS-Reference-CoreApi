<?php

$changeSettings['SYS'] = [
  'displayErrors' => 1,
  'devIPmask' => '*',
  'errorHandler' => 'TYPO3\\CMS\\Core\\Error\\ErrorHandler',
  'errorHandlerErrors' => E_ALL ^ E_NOTICE,
  'exceptionalErrors' => E_ALL ^ E_NOTICE ^ E_WARNING ^ E_USER_ERROR ^ E_USER_NOTICE ^ E_USER_WARNING,
  'debugExceptionHandler' => 'TYPO3\\CMS\\Core\\Error\\DebugExceptionHandler',
  'productionExceptionHandler' => 'TYPO3\\CMS\\Core\\Error\\DebugExceptionHandler',
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $changeSettings);
