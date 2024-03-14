<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;

$dataHandler = GeneralUtility::makeInstance(DataHandler::class);

$cmd = [];
$data = [];
$dataHandler->start($data, $cmd);
