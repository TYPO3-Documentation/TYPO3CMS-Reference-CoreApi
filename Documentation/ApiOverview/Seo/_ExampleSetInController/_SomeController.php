<?php

use MyVendor\MyExtension\PageTitle\MyOwnPageTitleProvider;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$titleProvider = GeneralUtility::makeInstance(MyOwnPageTitleProvider::class);
$titleProvider->setTitle('Title from controller action');
