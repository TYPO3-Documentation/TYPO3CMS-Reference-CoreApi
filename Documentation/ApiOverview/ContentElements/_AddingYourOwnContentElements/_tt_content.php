<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Schema\Struct\SelectItem;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

// Add the content element to the "Type" dropdown after the textmedia item
ExtensionManagementUtility::addRecordType(
  new SelectItem(
    type: 'select',
    label: 'Example - basic content',
    value: 'myextension_basiccontent',
    group: 'default',
  ),
  // Configure the default backend fields for the content element
  '
    --palette--;;headers,
    bodytext,
  ',
  [],
  'after:textmedia',
);
