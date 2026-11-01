<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Schema\Struct\SelectItem;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

// A table from comma separated values in the text field, with the separator
// of the field myextension_separator
ExtensionManagementUtility::addRecordType(
  new SelectItem(
    type: 'select',
    label: 'Example - table from CSV',
    value: 'myextension_newcontentcsv',
    icon: 'content-table',
    group: 'default',
    description: 'Shows comma separated values as a table.',
  ),
  '
    --palette--;;headers,
    bodytext,
    myextension_separator,
    imagecols,
  ',
  [],
  'after:myextension_basiccontent',
);
