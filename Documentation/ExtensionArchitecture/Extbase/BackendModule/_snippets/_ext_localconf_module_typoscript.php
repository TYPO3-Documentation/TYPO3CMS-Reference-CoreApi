<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addTypoScriptSetup('
  module.tx_myextension.persistence {
    storagePid = 42
    # Include records stored one level below page 42
    recursive = 1
  }
');
