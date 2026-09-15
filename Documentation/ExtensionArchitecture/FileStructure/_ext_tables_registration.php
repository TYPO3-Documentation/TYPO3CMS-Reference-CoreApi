<?php

use TYPO3\CMS\Core\DataHandling\PageDoktypeRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

GeneralUtility::makeInstance(PageDoktypeRegistry::class)->add(116, [
  'allowedTables' => ['tt_content', 'my_custom_record'],
]);
