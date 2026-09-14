<?php

use MyVendor\MyExtension\Middleware\Guzzle\CustomMiddleware;
use MyVendor\MyExtension\Middleware\Guzzle\SecondCustomMiddleware;
use TYPO3\CMS\Core\Utility\GeneralUtility;

// Add custom middlewares to default Guzzle handler stack
$GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler'][] =
  (GeneralUtility::makeInstance(CustomMiddleware::class))->handler();
$GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler'][] =
  (GeneralUtility::makeInstance(SecondCustomMiddleware::class))->handler();
