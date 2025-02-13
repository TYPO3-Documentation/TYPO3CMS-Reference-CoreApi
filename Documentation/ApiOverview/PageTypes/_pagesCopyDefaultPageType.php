<?php

defined('TYPO3') or die();

// encapsulate all locally defined variables
(function () {
    // ...code from previous example

    // Copy over all columns from default page type to allow TCA modifications
    // with f.e. ExtensionManagementUtility::addToAllTCAtypes()
    $GLOBALS['TCA']['pages']['types'][116] = $GLOBALS['TCA']['pages']['types'][1];
})();
