<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addTypoScriptSetup('
  module.tx_myextension.persistence {
    storagePid = 42
    recursive = 1
  }
  # Fall back to the page selected in the page tree
  module.tx_myextension_my_extension_moderation.persistence {
    storagePid = __UNSET
  }
');
