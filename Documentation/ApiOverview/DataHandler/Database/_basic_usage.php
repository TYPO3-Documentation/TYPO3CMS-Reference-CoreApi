<?php

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$dataHandler = GeneralUtility::makeInstance(DataHandler::class);

$cmd = [];
$data = [];
$dataHandler->start($data, $cmd);
